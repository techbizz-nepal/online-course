<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function metaTags()
    {
        return $this->belongsToMany(MetaTag::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
