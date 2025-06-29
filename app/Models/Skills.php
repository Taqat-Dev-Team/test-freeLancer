<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Skills extends Model implements HasMedia
{


    use HasTranslations, InteractsWithMedia;

    public $translatable = ['name'];
    protected $fillable = ['name', 'category_id', 'icon'];


    public function getImageUrl()
    {
        return $this->getFirstMediaUrl('icon', 'thumb') ?: url('logos/favicon.png');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function freeLancer()
    {
        return $this->belongsToMany(Freelancer::class, 'freelancers_skills', 'skill_id', 'freelancer_id')
            ->withTimestamps();

    }
}

