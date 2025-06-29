<?php

namespace App\Http\Requests\Front\Freelancer;

use Illuminate\Foundation\Http\FormRequest;

class LanguagesRequest extends FormRequest
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
            'languages' => ['required', 'array', 'min:1'],
            'languages.*.language_id' => ['required', 'exists:languages,id'],
            'languages.*.level' => ['required', 'integer', 'between:0,3'],
        ];
    }

    public function messages(): array
    {
        return [
            'languages.required' => __('validation.required', ['attribute' => __('messages.languages')]),
            'languages.array' => __('validation.array', ['attribute' => __('messages.languages')]),
            'languages.min' => __('validation.min.array', ['attribute' => __('messages.languages'), 'min' => 1]),

            'languages.*.language_id.required' => __('validation.required', ['attribute' => __('messages.language')]),
            'languages.*.language_id.exists' => __('validation.exists', ['attribute' => __('messages.language')]),

            'languages.*.level.required' => __('validation.required', ['attribute' => __('messages.language_level')]),
            'languages.*.level.integer' => __('validation.integer', ['attribute' => __('messages.language_level')]),
            'languages.*.level.between' => __('validation.between.numeric', [
                'attribute' => __('messages.language_level'),
                'min' => 0,
                'max' => 3,
            ]),
        ];
    }

}
