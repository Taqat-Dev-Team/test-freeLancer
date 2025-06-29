<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class IdentityVerification extends Model implements HasMedia
{
     use InteractsWithMedia;

     protected $table = 'identity_verifications';
     protected $fillable = [
        'freelancer_id', 'first_name', 'father_name', 'grandfather_name', 'family_name', 'id_number',
        'full_address', 'verification_date', 'phone', 'status', 'rejection_reason'
    ];

    public function getImageUrl()
    {
        return $this->getFirstMediaUrl('image','thumb') ?: url('logos/favicon.png');
    }


    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            '0' => 'Pending',
            '1' => 'Approved',
            '2' => 'Rejected',
            default => 'Unknown',
        };
    }


}













