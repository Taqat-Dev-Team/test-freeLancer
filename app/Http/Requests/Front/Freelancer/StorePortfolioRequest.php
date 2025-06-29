<?php

namespace App\Http\Requests\Front\Freelancer;

use Illuminate\Foundation\Http\FormRequest;

class StorePortfolioRequest extends FormRequest
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
            'title' => 'nullable|string|max:255',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'tags' => 'nullable|string',
            'content_blocks' => 'nullable|array',
            'content_blocks.*.type' => 'required_with:content_blocks|in:image,text',
        ];
    }
}
