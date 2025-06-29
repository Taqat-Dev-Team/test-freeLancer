<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\ApiResponseTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\PasswordReset as PasswordResetEvent;
use App\Models\User;

// تأكد من استيراد نموذج المستخدم الخاص بك

class ResetPasswordController extends Controller
{
    use ApiResponseTrait;

    /**
     * Reset the given user's password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => ['required', 'email'],
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            Log::warning('Password reset attempt failed due to validation errors.', ['errors' => $validator->errors()->all(), 'email' => $request->email]);
            return $this->apiResponse([], $validator->errors()->first(), false, 422);
        }

        $response = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                if (!$user) {
                    Log::error('User object is null inside password reset callback.');
                    return;
                }

                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->setRememberToken(null);

                $user->save();

                event(new PasswordResetEvent($user));
            }
        );

        switch ($response) {
            case Password::PASSWORD_RESET:
                Log::info('User password reset successfully.', ['email' => $request->email]);
                return $this->apiResponse([], 'تمت إعادة تعيين كلمة المرور بنجاح.', true, 200);

            case Password::INVALID_TOKEN:
                Log::error('Password reset failed: Invalid token.', ['email' => $request->email]);
                return $this->apiResponse([], 'رمز إعادة التعيين غير صالح أو منتهي الصلاحية.', false, 400);

            case Password::INVALID_USER:
                Log::error('Password reset failed: Invalid user (email not found).', ['email' => $request->email]);
                return $this->apiResponse([], 'البريد الإلكتروني غير مسجل لدينا.', false, 400);

            default:
                Log::error('Password reset failed: An unknown error occurred.', ['email' => $request->email]);
                return $this->apiResponse([], 'حدث خطأ غير متوقع أثناء إعادة تعيين كلمة المرور.', false, 500);
        }
    }
}
