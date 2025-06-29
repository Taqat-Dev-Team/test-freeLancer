<?php

namespace App\Http\Requests\Front\Freelancer;

use Illuminate\Foundation\Http\FormRequest;

class SkillsRequest extends FormRequest
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
            'skills' => ['required', 'array', 'max:16', 'exists:skills,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'skills.required' => __('validation.required', ['attribute' => __('messages.skills')]),
            'skills.array' => __('validation.array', ['attribute' => __('messages.skills')]),
            'skills.max' => __('validation.max.array', ['attribute' => __('messages.skills'), 'max' => 16]),
            'skills.exists' => __('validation.exists', ['attribute' => __('messages.skills')]),
        ];
    }
}
