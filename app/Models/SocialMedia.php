<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SocialMedia extends Model
{
    Use HasTranslations;
    protected $fillable = [
        'name',
        'icon',
    ];

    public $translatable = ['name'];
    public function freeLancer()
    {
        return $this->belongsToMany(Freelancer::class, 'free_lancer_social_media')
            ->withPivot(['link','title'])
            ->withTimestamps();
    }
}
