<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['title','name', 'email', 'phone', 'message', 'status', 'read_at'];

    public function reply()
    {
        return $this->hasOne(ContactReplay::class);
    }

}
