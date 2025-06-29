<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FreelancerWorkExperience extends Model
{
    protected $table='freelancer_work_experiences';
    protected $fillable = ['freelancer_id', 'company_name', 'title', 'location', 'type', 'start_date', 'end_date', 'description'];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }

    public function getDurationAttribute()
    {
        if ($this->end_date) {
            return round($this->start_date->diffInRealYears($this->end_date ?? now()));

        }
        return round( $this->start_date->diffInYears(now()));
    }

    public function getFormattedStartDateAttribute()
    {
        return Carbon::parse($this->start_date)->translatedFormat('F Y');
    }


    public function getFormattedEndDateAttribute()
    {
        return $this->end_date ? Carbon::parse($this->end_date)->translatedFormat('F Y') : __('messages.Present');
    }



}
