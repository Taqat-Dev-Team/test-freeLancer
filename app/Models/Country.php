<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasTranslations;
    protected $fillable = ['name', 'code', 'number_code','status'];

    protected $appends = ['flag'];


    public $timestamps = false;

    public $translatable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }


    public function getFlagAttribute()
    {
        $countryCode = strtolower($this->code);
        return "https://flagcdn.com/w40/{$countryCode}.png";
    }
}
