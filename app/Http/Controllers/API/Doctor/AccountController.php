<?php

namespace App\Http\Controllers\API\Doctor;

use App\Models\User;
use App\Models\Doctor;
use App\Models\UserPayout;
use App\Models\UserWallet;
use App\Models\DoctorPayout;
use Illuminate\Http\Request;
use App\Models\DoctorFeedback;
use App\Models\UserBookedSlot;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    
    public function index()
    {
        $data['breadcrumb']=   "Accounts";
        $data['wallet']= getDoctorWallet(Auth::user()->id);
        $data['earning']= DoctorPayout::where('doctor_id',Auth::user()->id)
                          ->where('status',1)->sum('amount');
        $data['requested']= DoctorPayout::where('doctor_id',Auth::user()->id)
                            ->where('status',0)->sum('amount');
        $data['payout']= DoctorPayout::where('doctor_id',Auth::user()->id)->orderBy('created_at','desc')->get();
        $data['accounts'] = UserBookedSlot::where('doctor_id',auth()->user()->id)->get();                 
        return res_success('Success!',['data'=> $data]);
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'bank_name' => 'required|string|max:255',
            'ifsc_code' => 'required|string|max:255',
            'account' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            ]
        );
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        }
        $Doctor = Doctor::find(Auth::user()->id);
        $Doctor->bank_name =  $request->bank_name;
        $Doctor->ifsc_code =  $request->ifsc_code;
        $Doctor->account =  $request->account;
        $Doctor->account_name =  $request->account_name;
        if($Doctor->save())
        {
            Session::flash('success', 'Your Account Detail Updated Successfully!');
        }
        
        return res_success('Success!',['data'=> $Doctor]);
    }

    public function payout(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'amount' => 'required|numeric',        
            ]
        );
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        }
        $payout =  new DoctorPayout();
        $payout->amount =  $request->amount;
        $payout->doctor_id =  Auth::user()->id;
        if($payout->save())
        {
            Session::flash('success', 'Your Payout Request Added Successfully!');
        }
    
        return res_success('Success!',['data'=> $payout]);
    }
}