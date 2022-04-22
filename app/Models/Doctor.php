<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $guard = 'doctor';

    public function findForPassport($username)
    {
        return $this->where('email', $username)
        ->orWhere('mobile', $username)
        ->first();
    }
    
    function getProfileImageAttribute($value)
    {
        return $value ? url(Storage::url($value)) : null;
    }

    public function getCreatedAtAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('d M Y'): null;
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d'): null;
    }

    // public function getstate()
    // {
    //     return $this->belongsTo(State::class,'state_id','id');
    // }
    // public function getcity()
    // {
    //     return $this->belongsTo(City::class,'city_id','id');
    // }
    public function getearning()
    {
        return $this->hasMany(DoctorPayout::class,'doctor_id','id');
    }
    public function getEntity()
    {
        return $this->belongsTo(Entity::class,'entity_id','id');
    }
    public function getarea()
    {
        return $this->belongsTo(Area::class,'area_id','id');
    }
    public function getRating()
    {
        return $this->hasMany(DoctorFeedback::class,'doctor_id','id');
    }
    public function getdoctorsession()
    {
        return $this->hasMany(Session::class,'doctor_id','id');
    }
    public function getspeciality()
    {
        return $this->belongsTo(Speciality::class,'speciality_id','id');
    }
    public function doctorAwards()
    {
        return $this->hasMany(DoctorAwards::class,'doctor_id','id');
    }
    public function doctorclinics()
    {
        return $this->hasOne(DoctorClinic::class,'doctor_id','id');
    }
    public function doctoreducation()
    {
        return $this->hasMany(DoctorEducation::class,'doctor_id','id');
    }
    public function doctorexperience()
    {
        return $this->hasMany(DoctorExperiance::class,'doctor_id','id');
    }
    public function doctorfeedback()
    {
        return $this->hasMany(DoctorFeedback::class,'doctor_id','id');
    }
    public function doctormembership()
    {
        return $this->hasMany(DoctorMembership::class,'doctor_id','id');
    }
    public function doctorregistration()
    {
        return $this->hasMany(DoctorRegistration::class,'doctor_id','id');
    }
    public function doctorpayout()
    {
        return $this->hasMany(DoctorPayout::class,'doctor_id','id');
    }
    public function doctortransaction()
    {
        return $this->hasMany(DoctorTransaction::class,'doctor_id','id');
    }
    public function doctorwallet()
    {
        return $this->hasMany(DoctorWallet::class,'doctor_id','id');
    }
}
