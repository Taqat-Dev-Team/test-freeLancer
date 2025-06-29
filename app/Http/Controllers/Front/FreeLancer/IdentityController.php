<?php

namespace App\Http\Controllers\Front\FreeLancer;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Freelancer\IdentityRequest;
use App\Http\Resources\UserResource;
use App\Models\IdentityVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class IdentityController extends Controller
{
    use ApiResponseTrait;

    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'digits_between:7,15', 'regex:/^[0-9]+$/'],
        ]);

        $otp = otp();

        Cache::put('otp_' . $request->mobile, $otp, now()->addMinutes(5));

        // SmsService::send($request->mobile, "Your OTP is: $otp");
        return $this->apiResponse(
            ['otp' => $otp],
            __('messages.otp_mobile_success'),
            true,
            200
        );
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'digits_between:7,15', 'regex:/^[0-9]+$/'],
            'otp' => 'required|digits:6'
        ]);

        $cacheKey = 'otp_' . $request->mobile;
        $storedOtp = Cache::get($cacheKey);
        $user = Auth::user();
        $user->update([
            'mobile_verified_at' => now(),
        ]);

        if (!$storedOtp || $request->otp != $storedOtp) {
            return $this->apiResponse(
                [],
                __('messages.invalid_otp'),
                false,
                422
            );
        }


        Cache::forget($cacheKey);
        return $this->apiResponse(
            [],
            __('messages.verified'),
            true,
            200
        );
    }


    public function updateIdentity(IdentityRequest $request)
    {
        $user = Auth::user();
        if ($user->mobile_verified_at === null) {
            return $this->apiResponse([], __('messages.phone_not_verified'), false, 500);
        }


        if ($user->mobile_verified_at < now()->subMinutes(5)) {
            return $this->apiResponse([], __('messages.otp_expired'), false, 500);
        }

        try {
            $identity = IdentityVerification::create([
                'freelancer_id' => auth()->user()->freelancer->id,
                'first_name' => $request->first_name,
                'father_name' => $request->father_name,
                'grandfather_name' => $request->grandfather_name,
                'family_name' => $request->family_name,
                'id_number' => $request->id_number,
                'full_address' => $request->full_address,

            ]);

            if (!$identity) {
                return $this->apiResponse([], __('messages.identity_update_failed'), false, 500);
            }

            if ($request->hasFile('image')) {
                $identity->addMediaFromRequest('image')
                    ->usingFileName(Str::random(20) . '.' . $request->file('image')->getClientOriginalExtension())
                    ->toMediaCollection('image', 'freelancersIds');
            }

            return $this->apiResponse(new UserResource($user), __('messages.identity_update_success'), true, 200);

        } catch (\Exception $e) {
            Log::error('Identity update error', [
                'freelancer_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->apiResponse([], __('messages.identity_update_failed'), false, 500);
        }
    }
}
