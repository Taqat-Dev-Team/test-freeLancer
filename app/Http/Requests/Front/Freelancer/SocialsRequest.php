<?php

namespace App\Http\Requests\Front\Freelancer;

use Illuminate\Foundation\Http\FormRequest;

class SocialsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'socials' => ['required', 'array'],
            'socials.*.social_id' => ['required', 'exists:social_media,id'],
            'socials.*.link' => ['required', 'url', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'socials.required' => __('validation.required', ['attribute' => __('messages.socials')]),
            'socials.array' => __('validation.array', ['attribute' => __('messages.socials')]),

            'socials.*.social_id.required' => __('validation.required', ['attribute' => __('messages.social_id')]),
            'socials.*.social_id.exists' => __('validation.exists', ['attribute' => __('messages.social_id')]),

            'socials.*.link.required' => __('validation.required', ['attribute' => __('messages.link')]),
            'socials.*.link.string' => __('validation.string', ['attribute' => __('messages.link')]),
            'socials.*.link.max' => __('validation.max.string', ['attribute' => __('messages.link'), 'max' => 255]),

        ];
    }

}
