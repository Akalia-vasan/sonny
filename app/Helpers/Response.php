<?php

use Carbon\Carbon;
use App\Models\City;
use App\Models\Doctor;
use App\Models\BedType;
use App\Models\Session;
use App\Models\UserOtp;
use App\Models\Voucher;
use App\Models\UserWallet;
use App\Models\SlotHistory;
use App\Models\DoctorWallet;
use App\Models\UserBookedSlot;
use App\Models\DoctorExperiance;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

if(!function_exists('res_success'))
{
    function res_success($message = 'Success!', $data = [])
    {
        return res(200, $message, $data);
    }
}

if(!function_exists('res_failed'))
{
    function res_failed($message = 'Failed!', $data = [])
    {
        return res(422, $message, $data);
    }
}

if(!function_exists('res'))
{
    function res($status_code, $message, $data = [])
    {
        return response()->json([
            'status'    =>  $status_code,
            'message'   =>  $message,
            'result'    =>  (object) $data
        ]);
    }
}

if(!function_exists('getcities'))
{
    function getcities($stateId)
    {
        $cities = City::where('state_id',$stateId)->get();
        return $cities;
    }
}

if(!function_exists('getdoctor'))
{
    function getdoctor($id)
    {
        $doctor = Doctor::where('id',$id)->first();
        return $doctor;
    }
}

if(!function_exists('getUserWallet'))
{
    function getUserWallet($id)
    {
        $wallet = UserWallet::where('user_id',$id)->first();
        if($wallet==null)
        {
            $wallet = new UserWallet();
            $wallet->user_id = $id;
            $wallet->amount = 0;
            $wallet->save();
        }
        return $wallet;
    }
}

if(!function_exists('getDoctorWallet'))
{
    function getDoctorWallet($id)
    {
        $wallet = DoctorWallet::where('doctor_id',$id)->first();
        if($wallet==null)
        {
            $wallet = new DoctorWallet();
            $wallet->doctor_id = $id;
            $wallet->amount = 0;
            $wallet->save();
        }
        return $wallet;
    }
}

if(!function_exists('slots'))
{
    function slots($day,$doctor_id)
    {
        $slots = Session::leftjoin('doctor_slots','sessions.id','doctor_slots.session_id')
        ->select('doctor_slots.*')
        ->where('sessions.doctor_id',$doctor_id)
        ->whereDate('doctor_slots.booking_date',Carbon::now()->adddays(+$day))
        ->where('doctor_slots.is_active',1)
        ->get();
        return $slots;
    }
}

if(!function_exists('getRemark'))
{
    function getRemark($slot_id)
    {
        $slots = SlotHistory::where('booked_slot_id',$slot_id)->orderBy('created_at','DESC')->limit(1)->get();
        if(count($slots)==1 && $slots[0]->remark){
            return $slots[0]->remark;
        }else{
            return '';
        }

    }
}


if(!function_exists('sendSms'))
{
    function sendSms($mobile, $message)
    {
        return true;
    }
}

if(!function_exists('sendOtp'))
{
    function sendOtp($mobile)
    {
        //$otp = mt_rand(1000, 9999);
        $otp = 1234;
        $message = "Your one time password is {$otp} Please use this One Time Password (OTP) within the next ten minutes to proceed. Thank you, SCREENBROS SERVICES PVT LTD";
        
        // $response = Http::get('', [
        //     'username'  =>  '',
        //     'message'   =>  $message,
        //     'sendername'=>  '',
        //     'smstype'   =>  'TRANS',
        //     'numbers'   =>  $mobile,
        //     'apikey'    =>  '',
        //     'peid'      =>  '',
        //     'templateid'=>  '',
        // ]);
        UserOtp::where('mobile',$mobile)->delete();
        UserOtp::updateOrCreate([
            'mobile' => $mobile
        ], [
            'otp'       =>  $otp,
            'attempt'   =>  0,
        ]);
        
        return true;
    }
}

if(!function_exists('EmailSendOtp'))
{
    function EmailSendOtp($email)
    {
        $otp = mt_rand(1000, 9999);
        // $otp = 1234;
        $details = [
            'otp' =>  $otp,
        ];
        Mail::to($email)->send(new \App\Mail\EmailVerification($details));
        UserOtp::where('email',$email)->where('otp','!=',0)->delete();
        UserOtp::updateOrCreate([
            'email' => $email
        ], [
            'otp'       =>  $otp,
            'attempt'   =>  0,
        ]);
        
        return true;
    }
}

if(!function_exists('getExp'))
{
    function getExp($doctor_id)
    {
        $exp = DoctorExperiance::where('doctor_id',$doctor_id)->orderBy('start_from','DESC')->limit(1)->get('start_from');
        if(count($exp)==1){
            return Carbon::now()->format('Y')-$exp[0]->start_from;
        }else{
            return 0;
        }

    }
}

if(!function_exists('updateCouponUses'))
{
    function updateCouponUses($code)
    {
        $counpon = Voucher::where('code',$code)->first();
        $counpon->used = $counpon->used +1 ;
        $counpon->save();
        return $counpon;
    }
}

if(!function_exists('getPercentage'))
{
    function getPercentage($bedtypeid,$price)
    {
        $BedType = BedType::find($bedtypeid);
        $percentage = $BedType->booking_percentage;
        $newPrice = ($price*$percentage)/100;       
        return $newPrice;
    }
}

if(!function_exists('Change'))
{
    function Change($value)
    {
        if($value){
            $length = floor(log10($value) + 1);
            if($length>2){
                $denom = pow(10, $length-2);
                $newval = $value/$denom;
                return $newval;  
            }else{
                return $value;  
            }
        }
        return 0;
    }
}

if(!function_exists('getAppointments'))
{
    function getAppointments($doctor_id)
    {
        if($doctor_id){
            $appointments = UserBookedSlot::where('doctor_id',$doctor_id)->count();
        }
        return 0;
    }
}