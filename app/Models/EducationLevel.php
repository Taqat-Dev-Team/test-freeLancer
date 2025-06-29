<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class EducationLevel extends Model
{
    use  HasTranslations;

    protected $table= 'education_levels';
    protected $fillable = ['name'];


    public $translatable = ['name'];

    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
