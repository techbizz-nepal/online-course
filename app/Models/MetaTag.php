<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaTag extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pages()
    {
        return $this->belongsToMany(Page::class);
    }
}
