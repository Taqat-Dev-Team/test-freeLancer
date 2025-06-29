<?php

namespace App\Http\Requests\Front\Freelancer;

use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'university' => 'required|string|max:255',
            'education_level_id' => 'required|exists:education_levels,id',
            'field_of_study' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'start_date' => ['required', 'date_format:m-Y'],
            'end_date' => ['nullable', 'date_format:m-Y', 'after_or_equal:start_date'],

        ];
    }

    public function messages(): array
    {
        return [
            'education_level_id.required' => __('validation.required', ['attribute' => __('messages.education_level')]),
            'education_level_id.exists' => __('validation.exists', ['attribute' => __('messages.education_level')]),

            'university.required' => __('validation.required', ['attribute' => __('messages.university')]),
            'field_of_study.required' => __('validation.required', ['attribute' => __('messages.field_of_study')]),
            'grade.required' => __('validation.required', ['attribute' => __('messages.grade')]),
            'start_date.required' => __('validation.required', ['attribute' => __('messages.start_date')]),
            'end_date.required' => __('validation.required', ['attribute' => __('messages.end_date')]),

            'start_date.date' => __('validation.date', ['attribute' => __('messages.start_date')]),
            'end_date.date' => __('validation.date', ['attribute' => __('messages.end_date')]),

            'start_date.before_or_equal' => __('validation.before_or_equal', ['attribute' => __('messages.start_date'), 'date' => __('messages.end_date')]),
            'end_date.after_or_equal' => __('validation.after_or_equal', ['attribute' => __('messages.end_date'), 'date' => __('messages.start_date')]),

            'university.string' => __('validation.string', ['attribute' => __('messages.university')]),
            'field_of_study.string' => __('validation.string', ['attribute' => __('messages.field_of_study')]),
            'grade.string' => __('validation.string', ['attribute' => __('messages.grade')]),

            'university.max' => __('validation.max.string', ['attribute' => __('messages.university'), 'max' => 255]),
            'field_of_study.max' => __('validation.max.string', ['attribute' => __('messages.field_of_study'), 'max' => 255]),
            'grade.max' => __('validation.max.string', ['attribute' => __('messages.grade'), 'max' => 255]),

            'start_date.date_format' => __('validation.date_format', ['attribute' => __('messages.start_date'), 'format' => 'Y-m-d']),
            'end_date.date_format' => __('validation.date_format', ['attribute' => __('messages.end_date'), 'format' => 'Y-m-d']),
        ];
    }
}
