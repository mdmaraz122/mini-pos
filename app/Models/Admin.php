<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'username',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'password',
        'dob',
        'gender',
        'image',
        'otp',
        '2fa_status',
        'status'
    ];
}
