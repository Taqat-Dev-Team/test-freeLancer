<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\ApiResponseTrait;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class SocialAuthController extends Controller
{
    use ApiResponseTrait;

    // توجيه المستخدم لصفحة مصادقة جوجل
    public function redirectToGoogle()
    {
        // Socialite::driver('google')->stateless() عشان الـ APIs و React
        return Socialite::driver('google')->stateless()->redirect();
    }


    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('google_id', $googleUser->id)->first();

            if (!$user) {
                $user = User::where('email', $googleUser->email)->first();
                if ($user) {
                    $user->google_id = $googleUser->id;
                    $user->provider = 'google';
                    $user->email_verified_at = $user->email_verified_at ?? Carbon::now();
                    $user->save();
                    Log::info('Existing user linked with Google account.', ['user_id' => $user->id, 'email' => $user->email]);
                } else {
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'provider' => 'google',
                        'email_verified_at' => Carbon::now(),
                        'password' => Hash::make(uniqid()),
                    ]);
                }
            } else {
                Log::info('User logged in via Google social login.', ['user_id' => $user->id, 'email' => $user->email]);
            }

            // إنشاء Sanctum Token
            $token = $user->createToken('auth-token')->plainTextToken;

            return redirect(env('FRONTEND_URL') . '/callback?' . http_build_query([
                    'token'     => $token,
                    'user_id'   => $user->id,
                    'user_type' => $user->freelancer? 'freelancer':'client',
                    'save_data' => $user->save_data,
                ]));


        } catch (Exception $e) {
            Log::error('Google social login failed.', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            // في حالة الفشل، يمكن إعادة التوجيه لـ frontend مع رسالة خطأ
            return redirect(env('FRONTEND_URL') . '/auth/callback#error=social_login_failed');
        }
    }



}


