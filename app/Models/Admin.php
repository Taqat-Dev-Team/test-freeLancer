<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\HasRolesAndPermissions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Admin extends Authenticatable implements HasMedia
{
    use Notifiable,InteractsWithMedia;

    use HasRolesAndPermissions;
    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password','photo',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getImageUrl()
    {
        return $this->getFirstMediaUrl('photo','thumb') ?: url('logos/favicon.png');
    }

}
