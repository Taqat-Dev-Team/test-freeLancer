<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SubCategory extends Model
{

    use HasTranslations;

    public $translatable = ['name','slug'];
    protected $fillable = ['category_id', 'name','slug'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function freelancers()
    {
        return $this->hasMany(Freelancer::class);
    }
}
