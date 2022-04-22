<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    public function doctoreslot()
    {
        return $this->hasMany(DoctorSlot::class,'session_id','id');
    }
}
