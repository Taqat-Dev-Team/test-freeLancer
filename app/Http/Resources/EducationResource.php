<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'university' => $this->university,
            'degree' => $this->educationLevel ? $this->educationLevel->name : null,
            'field_of_study' => $this->field_of_study,
            'grade' => $this->grade,
            'start_date' => $this->start_date ? $this->start_date->format('m-Y') : null,
            'end_date' => $this->end_date ? $this->end_date->format('m-Y') : null,
            'still_studying' => $this->end_date ? false : true,
        ];

    }
}
