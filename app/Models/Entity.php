<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entity extends Model
{
    use HasFactory;

    function getThumbnailAttribute($value)
    {
        return $value ? url(Storage::url($value)) : null;
    }

    public function scopeActive($query)
    {
        return $query->where('active',1);
    }
}
