<?php

namespace App\Http\Requests\Front\Freelancer;

use Illuminate\Foundation\Http\FormRequest;

class SaveDataRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bio' => 'nullable|string|max:1000',
            'birth_date' => 'required|date',
            'available_hire' => 'nullable|boolean',
            'hourly_rate' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'country_id' => 'required|exists:countries,id',
            'gender' => 'required|in:male,female',
            'mobile' => ['required', 'digits_between:7,15', 'regex:/^[0-9]+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('messages.name')]),
            'photo.required' => __('validation.required', ['attribute' => __('messages.photo')]),
            'photo.image' => __('validation.image', ['attribute' => __('messages.photo')]),
            'photo.mimes' => __('validation.mimes', ['attribute' => __('messages.photo')]),
            'photo.max' => __('validation.max.file', ['attribute' => __('messages.photo'), 'max' => 2048]),
            'bio.max' => __('validation.max.string', ['attribute' => __('messages.bio'), 'max' => 2000]),
            'birth_date.required' => __('validation.required', ['attribute' => __('messages.birth_date')]),
            'available_hire.boolean' => __('validation.boolean', ['attribute' => __('messages.available_hire')]),
            'category_id.required' => __('validation.required', ['attribute' => __('messages.category')]),
            'sub_category_id.required' => __('validation.required', ['attribute' => __('messages.sub_category')]),
            'country_id.exists' => __('validation.exists', ['attribute' => __('messages.country')]),
            'gender.required' => __('validation.required', ['attribute' => __('messages.gender')]),
            'gender.in' => __('validation.in', ['attribute' => __('messages.gender')]),
            'name.string' => __('validation.string', ['attribute' => __('messages.name')]),
            'name.max' => __('validation.max.string', ['attribute' => __('messages.name'), 'max' => 255]),
            'bio.string' => __('validation.string', ['attribute' => __('messages.bio')]),
            'birth_date.date' => __('validation.date', ['attribute' => __('messages.birth_date')]),
            'category_id.exists' => __('validation.exists', ['attribute' => __('messages.category')]),
            'sub_category_id.exists' => __('validation.exists', ['attribute' => __('messages.sub_category')]),
            'country_id.required' => __('validation.required', ['attribute' => __('messages.country')]),
            'mobile.required' => __('validation.required', ['attribute' => __('messages.mobile')]),
            'mobile.digits_between' => __('validation.digits_between', ['attribute' => __('messages.mobile'), 'min' => 7, 'max' => 15]),
            'mobile.regex' => __('validation.regex', ['attribute' => __('messages.mobile')]),

            'hourly_rate.numeric' => __('validation.numeric', ['attribute' => __('messages.hourly_rate')]),
            'hourly_rate.min' => __('validation.min.numeric', ['attribute' => __('messages.hourly_rate'), 'min' => 0]),


        ];
    }
}
