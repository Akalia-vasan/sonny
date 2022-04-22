<?php

namespace App\Http\Controllers\API\Doctor;

use Illuminate\Http\Request;
use App\Models\UserBookedSlot;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    
    public function index()
    {
        $data['breadcrumb']=   "My Patients";
        $data['patients'] = UserBookedSlot::where('doctor_id',4)->get()->unique('user_id');
        return res_success('Success!',['data'=>  $data]);
    }
}