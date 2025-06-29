<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FreelancerPortfolio extends Model implements HasMedia
{

    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'content',
        'freelancer_id',
        'tags'
    ];
    protected $casts = [
        'content' => 'array',
    ];

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }
    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }

    public function registerMediaCollections(): void
    {
        // مجموعة للصورة الرئيسية للمشروع (صورة واحدة فقط)
        $this->addMediaCollection('main_images')
            ->singleFile(); // يضمن أن هذه المجموعة تحتوي على ملف واحد فقط لكل موديل

        // مجموعة لصور المحتوى الديناميكي (يمكن أن تكون صور متعددة)
        $this->addMediaCollection('content_images')
            ->registerMediaConversions(function (Media $media) {
                // يمكنك إضافة تحويلات خاصة بصور المحتوى هنا
                // مثال على تحويل:
                $this->addMediaConversion('content_thumb')
                    ->width(800)
                    ->height(600)
                    ->sharpen(10); // مثال: إضافة حدة للصورة المصغرة
            });
    }
}
