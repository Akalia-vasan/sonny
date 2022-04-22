<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BeautyService extends Model
{
    use HasFactory;

    function getServiceImageAttribute($value)
    {
        return $value ? url(Storage::url($value)) : null;
    }
}
