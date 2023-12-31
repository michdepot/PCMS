<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
    ];

    // protected $hidden = [
    //     'password',
    // ];

    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
}
