<?php

namespace App\Http\Controllers\Patient;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Doctor;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Models\UserBookedSlot;
use App\Models\UserMedicalDetail;
use App\Models\UserMedicalRecord;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['breadcrumb'] = 'Dashboard';
        $data['bookedslot'] = UserBookedSlot::where('user_id',auth()->user()->id)->get();
        $data['medical_detail'] = UserMedicalDetail::where('user_id',auth()->user()->id)->orderBy('date','DESC')->limit(1)->first();
        $data['prescriptions'] = Prescription::where('user_id',auth()->user()->id)->orderBy('date','DESC')->get();
        $data['record']= UserMedicalRecord::where('user_id',Auth::user()->id)->get();           
        //dd($data['medical_detail']);
        return view('patient.home',$data);
    }

    public function prescriptionDetail($id) 
    {    
        $data['breadcrumb']=   "Prescription Detail";      
        $data['prescription'] = Prescription::where('id',$id)->orderBy('date','DESC')->first();
        return view('patient.show-prescription',$data);
    }

    public function password_reset_view($token)
    {
        $data['token_data'] = $token;
        return view('password_reset',$data);
    }

    public function updatepassword(Request $request,$token)
    {
        $validator = Validator::make($request->all(),[
            'password' => 'required|min:6|max:16|confirmed',
        ]);

        if($validator->fails())
        {
        	return redirect()->back()->withErrors($validator->errors());
        } 
        $tokendata = PasswordReset::where('token',$token)->first();

        if($tokendata)
        {
            $user = User::where('email',$tokendata['email'])->first();
            $instructor = Doctor::where('email',$tokendata['email'])->first();
            if($user)
            {
                $user->password = Hash::make($request->password);
                if($user->save())
                {
                    PasswordReset::where('token',$token)->delete(); 
                    return redirect('/index');
                }
            
            }
            elseif($instructor)
            {
                $instructor->password = Hash::make($request->password);
                $instructor->send_password = $request->password;
                if($instructor->save())
                {
                    PasswordReset::where('token',$token)->delete(); 
                    return redirect('/index');
                }
            }
            throw ValidationException::withMessages([
                'token' => 'Invalid Token.',
            ]);
        }
        else
        {
            throw ValidationException::withMessages([
                'token' => 'Reset Link Expired,Please Send Again.',
            ]);
        }
    }


}
