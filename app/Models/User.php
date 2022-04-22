<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $guard = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lname',
        'email',
        'mobile',
        'username',
        'password',
        'send_password',
        'profile_image',
        'dob',
        'gender',
        'blood_group',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'email_verified_at',
        'mobile_verified_at',
        'fcm_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function findForPassport($username)
    {
        return $this->where('email', $username)
        ->orWhere('mobile', $username)
        ->first();
    }

    function getProfileImageAttribute($value)
    {
        if (strpos($value, 'https') !== false) {
            return $value;
        }else{
            return $value ? url(Storage::url($value)) : null;
        }
    }

    public function getCreatedAtAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('d M Y'): null;
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d'): null;
    }

    public function getstate()
    {
        // return $this->hasOne(State::class, 'foreign_key', 'local_key');
        return $this->belongsTo(State::class,'state','id');
    }
    public function getcity()
    {
        return $this->belongsTo(City::class,'city','id');
    }
    public function getcountry()
    {
        return $this->belongsTo(Country::class,'country','id');
    }
    public function getslots()
    {
        return $this->hasMany(UserBookedSlot::class,'user_id','id');
    }
}
