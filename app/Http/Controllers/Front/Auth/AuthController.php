<?php

namespace App\Http\Controllers\Front\Auth;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Mail\OtpMail;
use App\Models\OtpCode;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_verified_at' => null,
            ]);

            // الآن sendOtp ترجع true أو false
            $otpSentSuccessfully = $this->sendOtp($user);

            if (!$otpSentSuccessfully) {
                DB::rollBack();
                Log::error('OTP email failed to send during registration, rolling back user creation.', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error_message' => __('messages.failed_to_send_otp_email')
                ]);
                // هنا نرجع استجابة فشل الإرسال
                return $this->apiResponse([], __('messages.failed_to_send_otp_email'), false, 500);
            }

            DB::commit();

            return $this->apiResponse(
                ['email' => $user->email, 'otp' => $user->otpCodes->last()->code],
                __('messages.register_success'),
                true,
                201
            );

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error during user registration process.', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return $this->apiResponse([], __('messages.registration_failed_email_issue'), false, 500);
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return $this->apiResponse([], __('messages.invalid_credentials'), false, 401);
        }

        $user = Auth::user();

        if ($user->status == 0) {
            Auth::logout();
            return $this->apiResponse([], __('messages.account_inactive'), false, 403);
        }
        if (is_null($user->email_verified_at)) {
            try {
                $otpSentSuccessfully = $this->sendOtp($user);
                if (!$otpSentSuccessfully) {
                    Log::error('Failed to re-send OTP during unverified user login.', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'error_message' => __('messages.failed_to_send_otp_email')
                    ]);
                    return $this->apiResponse([], __('messages.email_not_verified_otp_send_failed'), false, 500);
                }
                Auth::logout(); // تسجيل الخروج من المستخدم الذي لم يتم التحقق منه
                return $this->apiResponse(['is_verified' => false], __('messages.email_not_verified_send_otp'), false, 403);
            } catch (Exception $e) { // هذا الكاتش ربما لن يتم الوصول إليه إذا sendOtp تتعامل مع الـ Exception داخلياً
                Log::error('Unexpected error during OTP re-send in login.', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error' => $e->getMessage()
                ]);
                return $this->apiResponse([], __('messages.email_not_verified_otp_send_failed'), false, 500);
            }
        }

        $token = $user->createToken('token')->plainTextToken;

        return $this->apiResponse(
            new UserResource($user, $token),
            __('messages.login_success'),
            true,
            200
        );
    }

    /**
     * يرسل رمز OTP إلى المستخدم المحدد.
     */
    public function sendOtp(User $user): bool
    {
        try {
            $user->otpCodes()->where('expires_at', '>', Carbon::now())->delete();

            $otpCode = otp();
            $expiresAt = Carbon::now()->addMinutes(5);

            OtpCode::create([
                'user_id' => $user->id,
                'code' => $otpCode,
                'expires_at' => $expiresAt,
            ]);


            $userLocale = $user->lang ?? app()->getLocale();
            Mail::to($user->email)->send(new OtpMail($otpCode, $userLocale, $user->email)); // تمرير الـ locale

            return true; // نجاح العملية

        } catch (Exception $e) {
            Log::error('Failed to send OTP email.', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return false; // فشل العملية
        }
    }

    public function resendOtp(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return $this->apiResponse([], __('messages.user_not_found'), false, 404);
        }

        if (!is_null($user->email_verified_at)) {
            return $this->apiResponse([], __('messages.email_already_verified'), false, 400);
        }

        $existingValidOtp = $user->otpCodes()
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if ($existingValidOtp) {
            return $this->apiResponse([], __('messages.otp_already_sent'), false, 400);
        }

        $otpSentSuccessfully = $this->sendOtp($user);

        if (!$otpSentSuccessfully) {
            Log::error('Failed to send OTP during resendOtp request.', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error_message' => __('messages.failed_to_send_otp_email')
            ]);

            return $this->apiResponse([], __('messages.failed_to_send_otp_email'), false, 500);
        }

        return $this->apiResponse([], __('messages.otp_sent_successfully'), true, 200);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => [
                'required', 'string', 'email', 'max:255',
                'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,8}$/ix'
            ],
            'otp_code' => 'required|string|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->apiResponse([], __('messages.user_not_found'), false, 404);
        }

        if (!is_null($user->email_verified_at)) {
            return $this->apiResponse([], __('messages.email_already_verified'), false, 400);
        }

        $otp = OtpCode::where('user_id', $user->id)
            ->where('code', $request->otp_code)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$otp) {
            return $this->apiResponse([], __('messages.invalid_or_expired_otp'), false, 400);
        }

        $user->email_verified_at = Carbon::now();
        $user->save();
        $otp->delete();

        $token = $user->createToken('token')->plainTextToken;
        return $this->apiResponse(
            new UserResource($user, $token),
            __('messages.email_verified_successfully'),
            true,
            200
        );
    }

    public function profile(Request $request)
    {
        $user = Auth::user();

        $token = $this->extractBearerToken($request);

        return $this->apiResponse(
            new UserResource($user, $token),
            __('messages.profile_success'),
            true,
            200
        );
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return $this->apiResponse([], __('messages.not_authenticated'), false, 401);
        }

        $user->tokens()->delete();

        return $this->apiResponse([], __('messages.logout_success'), true, 200);
    }

    public function lang(Request $request)
    {
        $request->validate([
            'lang' => 'required|in:en,ar',
        ]);

        $user = Auth::user();
        if (!$user) {
            return $this->apiResponse([], __('messages.not_authenticated'), false, 401);
        }

        $token = $this->extractBearerToken($request);

        $oldLang = $user->lang;
        $user->lang = $request->lang;
        $user->save();

        app()->setLocale($user->lang);


        return $this->apiResponse(
            new UserResource($user, $token),
            __('messages.language_updated'),
            true,
            200
        );
    }

    public function type(Request $request)
    {
        $request->validate([
            'type' => 'required|in:1,2', // 1 for freelancer, 2 for client
        ]);

        $user = Auth::user('sanctum');

        if ($user->client || $user->freelancer) {
            return $this->apiResponse(['is_select_tye'=>1], __('messages.user_already_has_type'), false, 400);
        }
        $token = $this->extractBearerToken($request);

        if ($request->type == 2) {
            $user->client()->delete();
            $user->freelancer()->updateOrCreate(
                ['user_id' => $user->id],
                ['status' => 'active']
            );
        } else {
            $user->freelancer()->delete();
            $user->client()->updateOrCreate(
                ['user_id' => $user->id],
                ['status' => 'active']
            );
        }

        $user->load(['client', 'freelancer']);
        return $this->apiResponse(
            new UserResource($user, $token),
            __('messages.account_type_success'),
            true,
            200
        );
    }



}
