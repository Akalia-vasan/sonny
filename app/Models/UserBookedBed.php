<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBookedBed extends Model
{
    use HasFactory;
   
    public function getuserbooked()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function getbedbooked()
    {
        return $this->belongsTo(Bed::class,'bed_id','id');
    }
}

