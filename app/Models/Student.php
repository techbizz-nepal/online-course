<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends \Illuminate\Foundation\Auth\User
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];
}
