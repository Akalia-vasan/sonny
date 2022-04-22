<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    function getProductImageAttribute($value)
    {
        return $value!=null?url('storage').'/'.$value:"";
    }
}
