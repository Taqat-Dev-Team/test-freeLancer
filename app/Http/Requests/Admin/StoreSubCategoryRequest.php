<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubCategoryRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name_ar' => ['required', 'string', 'max:255', Rule::unique('sub_categories', 'name->ar')],
            'name_en' => ['required', 'string', 'max:255', Rule::unique('sub_categories', 'name->en')],
            'category_id' => ['required', 'exists:categories,id'],

        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => 'The Arabic name is required.',
            'name_en.required' => 'The English name is required.',
            'category_id.required' => 'The category is required.',
            'name_ar.unique' => 'The Arabic name must be unique.',
            'name_en.unique' => 'The English name must be unique.',
            'name_ar.max' => 'The Arabic name may not be greater than 255 characters.',
            'name_en.max' => 'The English name may not be greater than 255 characters.',
            'category_id.exists' => 'The selected category does not exist.',

        ];
    }
}
