<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use HasFactory;

    public function getbedtype()
    {
        return $this->belongsTo(BedType::class,'bed_type_id','id');
    }

    public function gethospitals()
    {
        return $this->belongsTo(Hospital::class,'hospital_id','id');
    }
}
