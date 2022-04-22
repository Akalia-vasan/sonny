<?php

namespace App\Http\Controllers\API\User;

use App\Models\Speciality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecialityController extends Controller
{
    public function getAllSpeciality(Request $request)
    {
        $speciality=Speciality::get();
        return res_success('Success!',['speciality'=>$speciality]);
    }
}
