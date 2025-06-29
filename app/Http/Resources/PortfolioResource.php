<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PortfolioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $content = $this->content;

        if (is_array($content)) {
            foreach ($content as $key => $block) {
                $content[$key]['block_index'] = $key; // 👈 أضف block_index هنا

                if ($block['type'] === 'image' && isset($block['media_id'])) {
                    $mediaItem = Media::find($block['media_id']);
                    $content[$key]['url'] = $mediaItem ? $mediaItem->getUrl() : null;
                }
            }
        }

        $mainImageUrl = optional($this->getFirstMedia('main_images'))->getUrl();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'main_image_url' => $mainImageUrl,
            'content' => $content,
            'tags' => $this->tags ? explode(',', $this->tags) : [],

        ];
    }
}
