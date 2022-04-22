<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOtp extends Model
{
    use HasFactory;

    protected $fillable = [
        'mobile',
        'email',
        'otp',
        'attempt',
        'email_link'
    ];
}
