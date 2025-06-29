<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


/**
 * Determine if the user is authorized to make this request.
 */
class StoreSocialRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_ar' => ['required', 'string', 'max:255', Rule::unique('social_media', 'name->ar')],
            'name_en' => ['required', 'string', 'max:255', Rule::unique('social_media', 'name->en')],
            'icon' => ['required', 'string', 'regex:/<svg[\s\S]*<\/svg>/i', Rule::unique('social_media', 'icon')],
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => 'The Arabic name is required.',
            'name_en.required' => 'The English name is required.',
            'icon.required' => 'The icon is required.',
            'icon.unique' => 'The icon must be unique.',

            'name_ar.unique' => 'The Arabic name must be unique.',
            'name_en.unique' => 'The English name must be unique.',
            'name_ar.max' => 'The Arabic name may not be greater than 255 characters.',
            'name_en.max' => 'The English name may not be greater than 255 characters.',

        ];
    }

}
