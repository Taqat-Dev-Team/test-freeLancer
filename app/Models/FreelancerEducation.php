<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreelancerEducation extends Model
{
    protected $fillable = ['university', 'education_level_id', 'field_of_study', 'grade', 'start_date', 'end_date', 'freelancer_id'];


//cast
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class);
    }
}



