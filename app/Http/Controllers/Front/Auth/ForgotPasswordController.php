<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\ApiResponseTrait;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    use ApiResponseTrait;

    /**
     * Send a reset link to the given user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => __('messages.email_not_registered'),
        ]);

        if ($validator->fails()) {
            return $this->apiResponse([], $validator->errors()->first(), false, 422);
        }

        $user = \App\Models\User::where('email', $request->email)->first();
        if (!$user) {
            // لمنع Enumeration Attack، نرجع رسالة عامة حتى لو الإيميل مش موجود
            return $this->apiResponse([], __('messages.password_reset_link_sent'), true, 200);
        }


        $userLocale = $user->lang ?? app()->getLocale();
        app()->setLocale($userLocale);

        $status = Password::broker()->sendResetLink(
            $request->only('email'),
            function ($user, $token) use ($userLocale) {
                try {
                    Mail::to($user->email)->send(new ResetPasswordMail($token, $user->email, $userLocale));
                } catch (\Exception $e) {
                    Log::error('Failed to send password reset link email.', [
                        'email' => $user->email,
                        'error' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine()
                    ]);

                    throw $e;
                }
            }
        );

        if ($status == Password::RESET_LINK_SENT) {
            return $this->apiResponse([], __('messages.password_reset_link_sent'), true, 200);
        }

        Log::error('Failed to send password reset link due to unexpected status.', ['email' => $request->email, 'status' => $status]);
        return $this->apiResponse([], __('messages.password_reset_link_failed'), false, 500);
    }
}
