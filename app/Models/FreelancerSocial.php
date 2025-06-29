<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreelancerSocial extends Model
{
    protected $table = 'free_lancer_social_media'; // اسم جدول العلاقة

    public $timestamps = false;

    protected $fillable = ['freelancer_id', 'social_media_id', 'link', 'title'];

    public function social()
    {
        return $this->belongsTo(SocialMedia::class, 'social_media_id');
    }
}
