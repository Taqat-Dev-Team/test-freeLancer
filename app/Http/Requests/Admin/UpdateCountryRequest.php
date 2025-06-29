<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


/**
 * Determine if the user is authorized to make this request.
 */
class UpdateCountryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('id');

        return [
            'name_ar' => ['required', 'string', 'max:255', Rule::unique('countries', 'name->ar')->ignore($id)],
            'name_en' => ['required', 'string', 'max:255', Rule::unique('countries', 'name->en')->ignore($id)],
            'code' => ['required', 'string', 'max:3', Rule::unique('countries', 'code')->ignore($id)],
            'number_code' => ['required', 'integer', 'min:1', Rule::unique('countries', 'number_code')->ignore($id)],
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => 'The Arabic name is required.',
            'name_en.required' => 'The English name is required.',
            'code.required' => 'The country code is required.',
            'number_code.required' => 'The number code is required.',
            'name_ar.unique' => 'The Arabic name must be unique.',
            'name_en.unique' => 'The English name must be unique.',
            'code.unique' => 'The country code must be unique.',
            'number_code.unique' => 'The number code must be unique.',
            'name_ar.max' => 'The Arabic name may not be greater than 255 characters.',
            'name_en.max' => 'The English name may not be greater than 255 characters.',
            'code.max' => 'The country code may not be greater than 3 characters.',
            'number_code.min' => 'The number code must be at least 1.',

        ];
    }

}
