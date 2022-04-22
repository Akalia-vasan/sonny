<?php

namespace App\Http\Controllers\API\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Setting;
use App\Models\UserWallet;
use App\Models\SlotHistory;
use App\Models\NurseBooking;
use Illuminate\Http\Request;
use App\Models\UserBookedSlot;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class HomeController extends Controller
{
    public function index()
    {
        $data['setting']=Setting::count();
        $data['total_user']=   User::count();
        $data['total_doctor']=    Doctor::count();
        $data['alldoctor'] = Doctor::limit(5)->get();
        $data['alluser'] = User::limit(5)->get();
        $data['appointment']=UserBookedSlot::get();
        return res_success('Success!',['data'=> $data]);
    }

    public function appointment() 
    {
        $data['appointment']=UserBookedSlot::get();
        return res_success('Success!',['data'=> $data]);
    }

    public function appointmentAccept($id)
    {
        $slots = UserBookedSlot::where('id',$id)->first();
        $doctorWallet = getDoctorWallet($slots->doctor_id);
        
        $doctorWallet->amount = $doctorWallet->amount + $slots->price;
        if($doctorWallet->save()) 
        {
            $slots->booking_status = 'Confirm';
            $slots->save();

            $slotHistory = new SlotHistory();
            $slotHistory->booked_slot_id =  $slots->id;
            $slotHistory->by =  'Doctor';
            $slotHistory->remark =  'Accepted By Admin';
            $slotHistory->created_at =  now();
            $slotHistory->updated_at =  now();
            $slotHistory->save();
        }
        return res_success('Success!',['data'=> $slotHistory ?? '']); 
    }

    public function appointmentCancel($id)
    {
        $slots = UserBookedSlot::where('id',$id)->first();

        $userWallet = UserWallet::where('user_id',$slots->user_id)->first();
        $userWallet->amount = $userWallet->amount + $slots->price;
        if($userWallet->save())
        {
            $slots->booking_status = 'Declined';
            $slots->save();

            $slotHistory = new SlotHistory();
            $slotHistory->booked_slot_id =  $slots->id;
            $slotHistory->by =  'Doctor';
            $slotHistory->remark =  'Declined By Admin';
            $slotHistory->created_at =  now();
            $slotHistory->updated_at =  now();
            $slotHistory->save();
        }

        return res_success('Success!',['data'=> $slotHistory ?? '']); 
    }

    public function appointmentCancelAccepted($id)
    {
        $slots = UserBookedSlot::where('id',$id)->first();
        
        $doctorWallet = getDoctorWallet($slots->doctor_id); 
        $doctorWallet->amount = $doctorWallet->amount - $slots->price;
        $doctorWallet->save();

        $userWallet = UserWallet::where('user_id',$slots->user_id)->first();
        $userWallet->amount = $userWallet->amount + $slots->price;
        if($userWallet->save())
        {
            $slots->booking_status = 'Declined';
            $slots->save();

            $slotHistory = new SlotHistory();
            $slotHistory->booked_slot_id =  $slots->id;
            $slotHistory->by =  'Doctor';
            $slotHistory->remark =  'Declined By Admin';
            $slotHistory->created_at =  now();
            $slotHistory->updated_at =  now();
            $slotHistory->save();
        }
        return res_success('Success!',['data'=> $slotHistory ?? '']);  
    }

    public function nurse_booking(Request $request){
        $data =  NurseBooking::get();
        return res_success('Success!',['data'=> $data]); 
    }

    public function update_nurse_booking_status(Request $request)
    {
        $id = $request->booking_id;
        NurseBooking::where('id', $id)->update(['status' => $request->status]);
        return res_success('Success!',['data'=> 'Status updated']); 
    }

    public function delete_nurse_booking_order($id)
    {
        NurseBooking::where('id', $id)->delete();
        return res_success('Success!',['data'=> 'Order Cancelled!']);
    }
}
