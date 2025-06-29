<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'description', 'type', 'fixed_price', 'duration_days',
        'hourly_price', 'weekly_hours', 'status',
        'client_id', 'freelancer_id', 'category_id',
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function freelancer() {
        return $this->belongsTo(Freelancer::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function attachments() {
        return $this->hasMany(ProjectAttachment::class);
    }

    public function skills() {
        return $this->belongsToMany(Skill::class, 'project_skills');
    }

    public function proposals() {
        return $this->hasMany(Proposal::class);
    }
}
