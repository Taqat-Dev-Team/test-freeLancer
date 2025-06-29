<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


/**
     * Determine if the user is authorized to make this request.
     */
class StoreSkillsRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'name_ar' => ['required', 'string', 'max:255', Rule::unique('skills', 'name->ar')],
            'name_en' => ['required', 'string', 'max:255', Rule::unique('skills', 'name->en')],
            'icon' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => 'The Arabic name is required.',
            'name_en.required' => 'The English name is required.',
            'icon.required' => 'The icon is required.',
            'icon.image' => 'The icon must be an image file.',
            'icon.mimes' => 'The icon must be a file of type: jpeg, png, jpg, gif, svg.',
            'icon.max' => 'The icon may not be greater than 2048 kilobytes.',
            'name_ar.unique' => 'The Arabic name must be unique.',
            'name_en.unique' => 'The English name must be unique.',
            'name_ar.max' => 'The Arabic name may not be greater than 255 characters.',
            'name_en.max' => 'The English name may not be greater than 255 characters.',
            'category_id.required' => 'The category is required.',
            'category_id.exists' => 'The selected category does not exist.',



        ];
    }

}
