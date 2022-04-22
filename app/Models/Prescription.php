<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    public function getuser()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function getdoctor()
    {
        return $this->belongsTo(Doctor::class,'doctor_id','id');
    }

    public function getdetail()
    {
        return $this->hasMany(PrescriptionDetail::class,'prescription_id','id');
    }
}
