<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkExperienceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'company_name' => $this->company_name,
            'title' => $this->title,
            'location' => $this->location,
            'type' => $this->type,
            'start_date' => $this->formatted_start_date,
            'end_date' => $this->formatted_end_date,
            'duration' => $this->duration,
            'description' => $this->description,
            'currently_working' => $this->end_date ? false : true,
        ];

    }
}
