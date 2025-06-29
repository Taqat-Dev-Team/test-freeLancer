<?php

namespace App\Http\Middleware;

use App\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NotVerificationMiddleware
{
    use ApiResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        $verification = $user->freelancer->identityVerification;

        if ($verification && !$verification->status == 2) {
            return $this->apiResponse([], __('messages.Access Denied'), false, 401);
        }

        return $next($request);
    }

}
