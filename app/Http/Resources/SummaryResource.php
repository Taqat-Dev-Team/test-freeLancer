<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SummaryResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'bio' => $this->bio,
            'video' => $this->video,
            'video_title' => $this->video_title,
            'images_title' => $this->images_title,
            'images_urls' => $this->freelancer->getImagesUrls(),
        ];


    }
}
