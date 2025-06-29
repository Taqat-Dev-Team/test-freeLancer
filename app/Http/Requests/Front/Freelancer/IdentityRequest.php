<?php

namespace App\Http\Requests\Front\Freelancer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class IdentityRequest extends FormRequest
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
        $id = Auth::user()->freelancer->id ?? null;

        return [

            'first_name' => 'required|string',
            'father_name' => 'required|string',
            'grandfather_name' => 'required|string',
            'family_name' => 'required|string',
            'id_number' => 'required|string|unique:identity_verifications,id_number,' . $id . ',freelancer_id',
            'full_address' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ];
    }

    public function messages(): array
    {
        return [

            'first_name.required' => __('validation.required', ['attribute' => __('messages.first_name')]),
            'father_name.required' => __('validation.required', ['attribute' => __('messages.father_name')]),
            'grandfather_name.required' => __('validation.required', ['attribute' => __('messages.grandfather_name')]),
            'family_name.required' => __('validation.required', ['attribute' => __('messages.family_name')]),
            'id_number.required' => __('validation.required', ['attribute' => __('messages.id_number')]),
            'id_number.unique' => __('validation.unique', ['attribute' => __('messages.id_number')]),
            'full_address.required' => __('validation.required', ['attribute' => __('messages.full_address')]),
            'full_address.string' => __('validation.string', ['attribute' => __('messages.full_address')]),
            'first_name.string' => __('validation.string', ['attribute' => __('messages.first_name')]),
            'father_name.string' => __('validation.string', ['attribute' => __('messages.father_name')]),
            'grandfather_name.string' => __('validation.string', ['attribute' => __('messages.grandfather_name')]),
            'family_name.string' => __('validation.string', ['attribute' => __('messages.family_name')]),
            'id_number.string' => __('validation.string', ['attribute' => __('messages.id_number')]),
            'image.required' => __('validation.required', ['attribute' => __('messages.image')]),
            'image.image' => __('validation.image', ['attribute' => __('messages.image')]),


        ];
    }
}
