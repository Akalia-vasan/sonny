<?php

namespace App\Http\Controllers\Patient;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorFeedback;
use App\Models\UserBookedBed;
use App\Models\UserOrder;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PatientController extends Controller
{
    public function applyCoupon(Request $request)
    {
        $couponCode = $request->couponCode;
        $coupon = Voucher::where('code',$couponCode)->first();
        return response()->json([
            'coupon'    =>  $coupon
        ]);
    }

    public function getcity(Request $request)
    {
        $cities = getcities($request->state_id);
        return response()->json([
            'cities'    =>  $cities
        ]);
    }

    public function add_review(Request $request)
    {
        //dd($request->all());
        $patient_id=Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'doctor_id' => 'required',
            'rating' => 'required',
            'type' => 'required|string|max:255',
            'feedback' => 'required|string|max:255',
            ]
        );
        if($validator->fails())
        {
        	return redirect()->back()->withErrors($validator->errors());
        }
        $DoctorFeedback = new DoctorFeedback();
        $DoctorFeedback->user_id =  $patient_id;
        $DoctorFeedback->doctor_id =  $request->doctor_id;
        $DoctorFeedback->rating =  $request->rating;
        $DoctorFeedback->type =  $request->type;
        $DoctorFeedback->feedback =  $request->feedback;
        if($DoctorFeedback->save())
            {
                Session::flash('success', 'Your Review Added Successfully!');
            }
        
        return redirect()->back();
    }

    public function changeprofile()
    {
        // dd(Auth::user()->getstate);
        $data['states'] = State::where('country_id',Auth::user()->country)->get();
        $data['cities'] = City::where('state_id',Auth::user()->state)->get();
        $data['breadcrumb'] = 'Profile Settings';
        return view('patient.change-profile',$data);
    }
    
    public function updateprofile(Request $request)
    {
        $patient_id=Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'dob' => 'required|date_format:Y-m-d',
            'blood_group' => 'required|not_in:0',
            'gender' => 'required|in:Female,Male',
            'email' => 'required|email|unique:users,email,'.$patient_id,
            'mobile' => 'required|regex:/[6789][0-9]{9}/|unique:users,mobile,'.$patient_id,
            'profile_image'=>'sometimes|nullable|mimes:jpg,png,jpeg|max:2000',
            'address' => 'required|string|max:255',
            'state' => 'required|not_in:0',
            'zip' => 'required|numeric',
            'city' => 'required|not_in:0',
            'country' => 'required|not_in:0',
            ]
        );
        if($validator->fails())
        {
        	return redirect()->back()->withErrors($validator->errors());
        }
        
            $editprofile= User::where('id',Auth::user()->id)->first();
            $editprofile->name =  $request->name;
            $editprofile->lname =  $request->lname;
            $editprofile->email =  $request->email;
            $editprofile->mobile =  $request->mobile;
            $editprofile->dob =  $request->dob;
            $editprofile->gender =  $request->gender;
            $editprofile->blood_group =  $request->blood_group;
            $editprofile->address =  $request->address;
            $editprofile->city =  $request->city;
            $editprofile->state =  $request->state;
            $editprofile->country =  $request->country;
            $editprofile->zip =  $request->zip;
            if($request->has('profile_image')) 
            {
                
                //Image delete
                $filePath = @$editprofile->getAttributes()['profile_image'];
                
                if($filePath != null)
                {
                    $filePath1 = storage_path('app/public/'.$editprofile->getAttributes()['profile_image']);
                    unlink($filePath1);
                } 
                $profilefile = $request->file('profile_image');
                $destinationPath1 ='public/PatientProfile/';
                $profile_image = time().'_'.$profilefile->getClientOriginalName();
                $upload_success1 = $request->file('profile_image')->storeAs('public/PatientProfile',$profile_image);    
                $uploaded_profile_image = 'PatientProfile/'.$profile_image; 
                $editprofile->profile_image =  $uploaded_profile_image;
            
            }
            if($editprofile->update())
            {
                Session::flash('success', 'Your Profile Update Successfully!');
            }
        
        return redirect()->back();
    }

    public function changepassword()
    {
        $data['breadcrumb'] = 'Change Password';
        return view('patient.change-password',$data);
    }

    public function updatechangepassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'password' => 'required|min:6|max:16|confirmed',
        ]);

        if($validator->fails())
        {
        	return redirect()->back()->withErrors($validator->errors());
        } 
        if( ! Hash::check( $request->old_password ,auth()->user()->password) )
        {
            throw ValidationException::withMessages([
                'old_password' => 'Old Password does not match.',
            ]);
        }
        if( $request->old_password == $request->password )
        {
            throw ValidationException::withMessages([
                'password' => 'New Password can not same as Old Password.',
            ]);
        }
        $user = User::where('email',Auth::user()->email)->first();
        $user->password = Hash::make($request->password);
        if($user->save())
        {
            Session::flash('success', "Your Password Changed Successfully!");
        }
        return redirect()->route('patient.home');

    }

    public function favourite()
    {
        $data['doctor'] = Doctor::join('user_booked_slots','user_booked_slots.doctor_id','doctors.id')
        ->where('user_booked_slots.user_id',Auth::user()->id)->get()->unique('user_booked_slots.doctor_id');
        $data['breadcrumb'] = 'Favourites';
        return view('patient.favourite',$data);
    }

    public function bedbookingorder()
    {
        $data['userbookedbed'] = UserBookedBed::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->get();
        $data['breadcrumb'] = 'Bed Booking Order History';
        return view('patient.bed_booking_order_history',$data);
    }
}
