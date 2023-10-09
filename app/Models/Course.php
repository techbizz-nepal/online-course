<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function bookingDates(){
        return $this->hasMany(BookingDate::class);
    }

    public function page(){
        return $this->hasOne(Page::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
