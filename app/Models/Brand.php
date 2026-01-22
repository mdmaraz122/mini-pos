<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'admin_id',
        'name',
        'slug',
        'image',
        'status'
    ];
}
