<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


/**
 * Determine if the user is authorized to make this request.
 */
class UpdateEducationLevelRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('id');

        return [
            'name_ar' => ['required', 'string', 'max:255', Rule::unique('education_levels', 'name->ar')->ignore($id)],
            'name_en' => ['required', 'string', 'max:255', Rule::unique('education_levels', 'name->en')->ignore($id)],

        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => 'The Arabic name is required.',
            'name_en.required' => 'The English name is required.',
            'name_ar.unique' => 'The Arabic name must be unique.',
            'name_en.unique' => 'The English name must be unique.',
            'name_ar.max' => 'The Arabic name may not be greater than 255 characters.',
            'name_en.max' => 'The English name may not be greater than 255 characters.',

        ];
    }

}
