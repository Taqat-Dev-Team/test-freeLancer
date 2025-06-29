<?php

namespace App\Http\Requests\Front\Freelancer;

use Illuminate\Foundation\Http\FormRequest;

class AbouteRequest extends FormRequest
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
            'available_hire' => 'nullable|boolean',
            'hourly_rate' => 'nullable|numeric|min:0',
            'country_id' => 'required|exists:countries,id',
            'experience' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',

        ];
    }

    public function messages(): array
    {
        return [
            'available_hire.boolean' => __('validation.boolean', ['attribute' => __('messages.available_hire')]),
            'hourly_rate.numeric' => __('validation.numeric', ['attribute' => __('messages.hourly_rate')]),
            'hourly_rate.min' => __('validation.min.numeric', ['attribute' => __('messages.hourly_rate'), 'min' => 0]),
            'country_id.exists' => __('validation.exists', ['attribute' => __('messages.country')]),
            'country_id.required' => __('validation.required', ['attribute' => __('messages.country')]),
            'category_id.required' => __('validation.required', ['attribute' => __('messages.category')]),
            'sub_category_id.required' => __('validation.required', ['attribute' => __('messages.sub_category')]),
            'category_id.exists' => __('validation.exists', ['attribute' => __('messages.category')]),
            'sub_category_id.exists' => __('validation.exists', ['attribute' => __('messages.sub_category')]),

        ];
    }
}
