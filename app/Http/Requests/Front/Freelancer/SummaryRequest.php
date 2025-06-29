<?php

namespace App\Http\Requests\Front\Freelancer;

use Illuminate\Foundation\Http\FormRequest;

class SummaryRequest extends FormRequest
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
            'bio' => 'required|string|max:4000',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images_title' => 'nullable|string|max:255',
            'video' => ['nullable', 'string', 'max:255', 'regex:/^(https?\:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/'],
            'video_title' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'bio.required' => __('messages.Bio is required'),
            'bio.string' => __('messages.Bio must be a string'),
            'bio.max' => __('messages.Bio must not exceed 4000 characters'),
            'images.array' => __('messages.Images must be an array'),
            'images.*.image' => __('messages.Each image must be a valid image file'),
            'images.*.mimes' => __('messages.Image must be of type jpeg, png, jpg, gif, or svg'),
            'images.*.max' => __('messages.Image size must not exceed 2MB'),
            'images_title.string' => __('messages.Image title must be a string'),
            'images_title.max' => __('messages.Image title must not exceed 255 characters'),
            'video.string' => __('messages.Video URL must be a string'),
            'video.max' => __('messages.Video URL must not exceed 255 characters'),
            'video.regex' => __('messages.Video URL must be a valid YouTube link'),
            'video_title.string' => __('messages.Video title must be a string'),
            'video_title.max' => __('messages.Video title must not exceed 255 characters'),

        ];
    }

}
