<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\ApiResponseTrait;

class EnsureEmailIsVerified
{
    use ApiResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // تحقق إذا كان المستخدم مسجل دخول
        if (!Auth::check()) {
            return $this->apiResponse([], __('messages.not_authenticated'), false, 401);
        }

        $user = Auth::user();

        if (is_null($user->email_verified_at)) {
//             Auth::logout();
            return $this->apiResponse([], __('messages.email_not_verified_access_denied'), false, 403);
        }

        return $next($request);
    }
}
