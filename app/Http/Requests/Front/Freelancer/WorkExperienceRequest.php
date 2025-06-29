<?php

namespace App\Http\Requests\Front\Freelancer;

use Illuminate\Foundation\Http\FormRequest;

class WorkExperienceRequest extends FormRequest
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
            'company_name' => ['required', 'string', 'max:255'],
            'title'        => ['required', 'string', 'max:255'],
            'location'     => ['nullable', 'string', 'max:255'],
            'type'         => ['required', 'in:full_time,on-site,hybrid,remote'],
            'start_date' => ['required', 'date_format:m-Y'],
            'end_date' => ['nullable', 'date_format:m-Y', 'after_or_equal:start_date'],

            'description'  => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'company_name.required'     => __('messages.company_name_required'),
            'company_name.string'       => __('messages.company_name_string'),
            'company_name.max'          => __('messages.company_name_max_length'),

            'title.required'            => __('messages.title_required'),
            'title.string'              => __('messages.title_string'),
            'title.max'                 => __('messages.title_max_length'),

            'location.string'           => __('messages.location_string'),
            'location.max'              => __('messages.location_max_length'),

            'type.required'             => __('messages.type_required'),
            'type.in'                   => __('messages.type_invalid', ['valid_types' => 'on-site, remote, hybrid, full_time']),

            'start_date.required'       => __('messages.start_date_required'),
            'start_date.date_format'    => __('messages.start_date_format'),

            'end_date.date_format'      => __('messages.end_date_format'),
            'end_date.after_or_equal'   => __('messages.end_date_after_start_date'),

            'description.string'        => __('messages.description_string'),
            'description.max'           => __('messages.description_max_length', ['max' => 1000]),
        ];
    }


}
