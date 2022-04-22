<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBookedSlot extends Model
{
    use HasFactory;

    public function getdoctorbooked()
    {
        return $this->belongsTo(Doctor::class,'doctor_id','id');
    }
    public function getuserbooked()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function getslotbooked()
    {
        return $this->belongsTo(DoctorSlot::class,'slot_id','id');
    }

    public function getOrder()
    {
        return $this->belongsTo(UserOrder::class,'order_id','id');
    }

}
