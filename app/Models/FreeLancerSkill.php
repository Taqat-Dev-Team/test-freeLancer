<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeLancerSkill extends Model
{
    protected $table = 'freelancers_skills';

    protected $fillable = [
        'freelancer_id',
        'skill_id',
    ];

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skills::class);
    }
}
