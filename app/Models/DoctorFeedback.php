<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorFeedback extends Model
{
    use HasFactory;

    public function getUser()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::createFromTimeStamp(strtotime($value))->diffForHumans():null;
    }
}
