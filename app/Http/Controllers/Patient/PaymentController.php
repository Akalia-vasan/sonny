<?php

namespace App\Http\Controllers\Patient;

use App\Models\Bed;
use Razorpay\Api\Api;
use App\Models\Doctor;
use App\Models\Voucher;
use App\Models\UserOrder;
use App\Models\DoctorSlot;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Models\UserBookedSlot;
use App\Http\Controllers\Controller;
use App\Models\UserBookedBed;
use Illuminate\Support\Facades\Auth;
use App\Models\UserWalletTransaction;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function prepaymentdata1(Request $request)
    {
        if($request->slot_id==null)
        {
            return redirect()->back()->with('error','Firstly Choose Slot');
        }
        $data['breadcrumb'] = 'Checkout';
        $data['slotdata'] = DoctorSlot::where('id',$request->slot_id)->first();
        $data['doctordata'] = Doctor::where('id',$request->doctor_id)->first();
        $data['wallet'] = getUserWallet(auth()->user()->id);
        
        return view('patient.checkout',$data);
    }
    public function prepaymentdata(Request $request)
    {
        //dd($request->all());
        if($request->slot_id==null)
        {
            return redirect()->back()->with('error','Firstly Choose Slot');
        }
        $data['breadcrumb'] = 'Confirm And Pay';
        $data['slotdata'] = DoctorSlot::where('id',$request->slot_id)->first();
        $data['doctordata'] = Doctor::where('id',$request->doctor_id)->first();
        $data['wallet'] = getUserWallet(auth()->user()->id);
        $data['voucher'] = $request->voucher;
        $data['voucher_price'] = $request->coupon_amount;
        $data['new_amount'] = $request->new_amount;
        
        return view('patient.checkout2',$data);
    }

    public function initiatepayment(Request $request)
    {    
    
        $coupon_price = $request->coupon_price;
        $wallet_price = $request->wallet_price;
        $userWallet = getUserWallet(Auth::user()->id);
        $doctor = Doctor::find($request->doctor_id);
        $doctor_price =  $doctor->price;
        $pay_online = $request->total_amount;
        if($request->coupon!=null && $request->check=='on')
        {
            if($request->total_amount==0){
                $source = 'coupon with wallet';
            }else{
                $source = 'coupon with wallet and online';
            }
        }
        elseif($request->coupon!=null && $request->check==null)
        {
            $source = 'coupon';
        }
        elseif($request->coupon==null && $request->check=='on')
        {
            if($request->total_amount==0){
                $source = 'wallet';
            }else{
                $source = 'partial wallet';
            }
        }
        else
        {
            $source = 'online';
        }
       
        if($request->total_amount<=0)
        {
          $tid = 'Order_'.time();

          $UserOrder = new UserOrder();
          $UserOrder->orderId = $tid;
          $UserOrder->user_id = auth()->user()->id;
          $UserOrder->transaction_id = $tid;
          $UserOrder->source = $source;
          $UserOrder->wallet_deduct = $wallet_price;
          $UserOrder->coupon_code = $request->coupon;
          $UserOrder->coupon_price = $coupon_price;
          $UserOrder->online_paid = 0;
          $UserOrder->total_price = $doctor->price;
          $UserOrder->type = 'slot';
          $UserOrder->status = 'completed';
          if($UserOrder->save()){
              $userBookedSlot = new UserBookedSlot();
              $userBookedSlot->user_id = auth()->user()->id;
              $userBookedSlot->doctor_id = $request->doctor_id;
              $userBookedSlot->slot_id = $request->slot_id;
              $userBookedSlot->order_id = $UserOrder->id;
              $userBookedSlot->price = $doctor->price;
              $userBookedSlot->booking_status = 'Pending';
              $userBookedSlot->save();
          }
          
          $wallet = getUserWallet(auth()->user()->id);
          $wallet->amount = $wallet->amount - $doctor->price;
          if($wallet->save()){
              $walletTransaction = new UserWalletTransaction();
              $walletTransaction->wallet_id = $wallet->id;
              $walletTransaction->order_id = $UserOrder->id; 
              $walletTransaction->transaction_amount = $doctor->price;
              $walletTransaction->description = 'Slot Booking Price!';
              $walletTransaction->save();
          }
          if($UserOrder->coupon_code!=null)
            {
                $updatecoupon = updateCouponUses($UserOrder->coupon_code);
            }
          $slot = DoctorSlot::find($request->slot_id);
          $slot->is_booked = 1;
          $slot->save();
          Session::flash('success', 'Your Appointment Booked Successfully with Dr. '.$doctor->name.' '.$doctor->l_name.' on '.$slot->booking_date.' at '.$slot->slot_name);
          return redirect('home');
        }
        else
        { 
            $amount = $pay_online ;
            $slot_id = $request->slot_id;
            $doctor_id = $request->doctor_id;
            $check = $request->check=='on'?1:0;
            $user_id = Auth::user()->id;
            $fname = Auth::user()->name;
            $lname = Auth::user()->lname;
            $mobile = Auth::user()->mobile;
            $email = Auth::user()->email;

            $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
            $order = $api->order->create(array( 
                'amount' => $amount * 100, 
                'payment_capture' => 1, 
                'currency' => 'INR' 
            ));
            $rzp_order_id = $order['id'];
            $response=[
                'orderId'=>$rzp_order_id,
                'slot_id'=>$slot_id,
                'doctor_id'=>$doctor_id,
                'razorpayId'=>env('RAZOR_KEY'),
                'amount'=>$amount * 100, 
                'check'=>$check, 
                'name'=>Auth::user()->name.' '.Auth::user()->lname,
                'currency'=>'INR',
                'email'=>Auth::user()->email,
                'mobile'=>Auth::user()->mobile,
                'description'=>'Booking Slot',
                'wallet_price' => $wallet_price,
                'coupon_code' => $request->coupon,
                'coupon_price' => $coupon_price,
                'source' => $source,
            ];
            return view('payment.payment-processing',compact('response'));      
        }
    }
    public function payment_complete(Request $request)
    {
        $amount = $request->pay_amount;
        $slot_id = $request->slot_id;
        $doctor_id = $request->doctor_id;
        $check = $request->check;
        $wallet_price = $request->wallet_price;
        $coupon_code = $request->coupon_code;
        $coupon_price = $request->coupon_price;
        $source = $request->source;

        $signatureStatus= $this->SignatureVerify(
            $request->all()['rzp_signature'],
            $request->all()['rzp_paymentid'],
            $request->all()['rzp_orderid']
        );
        if($signatureStatus==true)
        {
            $payorderid=$request->all()['rzp_orderid'];
            $paymentid=$request->all()['rzp_paymentid'];
            $signature_id=$request->all()['rzp_signature'];  

            $doctor = Doctor::find($request->doctor_id);

            $UserOrder = new UserOrder();
            $UserOrder->orderId = $payorderid;
            $UserOrder->user_id = auth()->user()->id;
            $UserOrder->transaction_id = $paymentid;
            $UserOrder->source = $source;
            $UserOrder->wallet_deduct = $wallet_price;
            $UserOrder->coupon_code = $coupon_code;
            $UserOrder->coupon_price = $coupon_price;
            $UserOrder->online_paid = $request->pay_amount;
            $UserOrder->total_price = $doctor->price;
            $UserOrder->type = 'slot';
            $UserOrder->status = 'completed';
            if($UserOrder->save()){
                $userBookedSlot = new UserBookedSlot();
                $userBookedSlot->user_id = auth()->user()->id;
                $userBookedSlot->doctor_id = $request->doctor_id;
                $userBookedSlot->slot_id = $request->slot_id;
                $userBookedSlot->order_id = $UserOrder->id;
                $userBookedSlot->price = $doctor->price;
                $userBookedSlot->booking_status = 'Pending';
                $userBookedSlot->save();
            }
          if($check==1)
          {
                $wallet = getUserWallet(auth()->user()->id);
                $wallet->amount = 0;
                if($wallet->save()){
                    $walletTransaction = new UserWalletTransaction();
                    $walletTransaction->wallet_id = $wallet->id;
                    $walletTransaction->order_id = $UserOrder->id; 
                    $walletTransaction->transaction_amount = $UserOrder->wallet_deduct;
                    $walletTransaction->description = 'Slot Booking Price!';
                    $walletTransaction->save();
                }
            }
            if($UserOrder->coupon_code!=null)
            {
                $updatecoupon = updateCouponUses($UserOrder->coupon_code);
            }
          $slot = DoctorSlot::find($request->slot_id);
          $slot->is_booked = 1;
          $slot->save();

          Session::flash('success', 'Your Appointment Booked Successfully with Dr. '.$doctor->name.' '.$doctor->l_name.' on '.$slot->booking_date.' at '.$slot->slot_name);
        }
        return redirect('home');
    }
    protected function SignatureVerify($_signature,$_paymentId,$_orderId)
    {
        try
        {
            $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
            $attributes  = array('razorpay_signature'  => $_signature,  'razorpay_payment_id'  => $_paymentId ,  'razorpay_order_id' => $_orderId);
            $order  = $api->utility->verifyPaymentSignature($attributes);
            return true;
        }
        catch(\Exception $e)
        {
            Session::flash('failed', 'Transaction Error');
            return redirect('home');
        }
    }
    public function paymentfailed(Request $request)
    {
        Session::flash('failed', 'Transaction Error');
        return redirect('home');
    
    }

    public function prepaymentdataforbed1($id)
    {
        $data['breadcrumb'] = 'Bed Booking Checkout';
        $data['allbed'] = Bed::where('id',$id)->first();
        $data['wallet'] = getUserWallet(auth()->user()->id);   
        return view('patient.bed_checkout',$data);
    }

    public function prepaymentdataforbed(Request $request)
    {
        $data['breadcrumb'] = 'Confirm And Pay';
        $data['allbed'] = Bed::where('id',$request->bed_id)->first();
        $data['wallet'] = getUserWallet(auth()->user()->id);
        $data['voucher'] = $request->voucher;
        $data['voucher_price'] = $request->coupon_amount;
        $data['new_amount'] = $request->new_amount;
        
        return view('patient.bed_checkout2',$data);
    }
    
    public function initiatepaymentforbed(Request $request)
    {    
        // dd($request->all());
        $coupon_price = $request->coupon_price;
        $wallet_price = $request->wallet_price;
        $userWallet = getUserWallet(Auth::user()->id);
        $bed = Bed::find($request->bed_id);
        $bed_price =  $bed->price;
        $pay_online = $request->total_amount;
        if($request->coupon!=null && $request->check=='on')
        {
            if($request->total_amount==0){
                $source = 'coupon with wallet';
            }else{
                $source = 'coupon with wallet and online';
            }
        }
        elseif($request->coupon!=null && $request->check==null)
        {
            $source = 'coupon';
        }
        elseif($request->coupon==null && $request->check=='on')
        {
            if($request->total_amount==0){
                $source = 'wallet';
            }else{
                $source = 'partial wallet';
            }
        }
        else
        {
            $source = 'online';
        }
       
        if($request->total_amount<=0)
        {
          $tid = 'Order_'.time();

          $UserOrder = new UserOrder();
          $UserOrder->orderId = $tid;
          $UserOrder->user_id = auth()->user()->id;
          $UserOrder->transaction_id = $tid;
          $UserOrder->source = $source;
          $UserOrder->wallet_deduct = $wallet_price;
          $UserOrder->coupon_code = $request->coupon;
          $UserOrder->coupon_price = $coupon_price;
          $UserOrder->online_paid = 0;
          $UserOrder->total_price = $bed->price;
          $UserOrder->type = 'bed';
          $UserOrder->status = 'completed';
          if($UserOrder->save()){
            $UserBookedBed = new UserBookedBed();
            $UserBookedBed->user_id = auth()->user()->id;
            $UserBookedBed->bed_id = $request->bed_id;
            $UserBookedBed->order_id = $UserOrder->id;
            $UserBookedBed->price = $bed->price;
            $UserBookedBed->booking_status = 'Confirm';
            $UserBookedBed->save();
        }
          
          $wallet = getUserWallet(auth()->user()->id);
          $wallet->amount = $wallet->amount - $bed->price;
          if($wallet->save()){
              $walletTransaction = new UserWalletTransaction();
              $walletTransaction->wallet_id = $wallet->id;
              $walletTransaction->order_id = $UserOrder->id; 
              $walletTransaction->transaction_amount = $bed->price;
              $walletTransaction->description = 'Bed Booking Price!';
              $walletTransaction->save();
          }
          if($UserOrder->coupon_code!=null)
            {
                $updatecoupon = updateCouponUses($UserOrder->coupon_code);
            }
            $bed->aval_bed = $bed->aval_bed -1 ;
            $bed->save();
        //   $slot = DoctorSlot::find($request->slot_id);
        //   $slot->is_booked = 1;
        //   $slot->save();
          Session::flash('success', 'Your Bed Booked Successfully.');
          return redirect('home');
        }
        else
        { 
            $amount = $pay_online ;
            $bed_id = $request->bed_id;
            $check = $request->check=='on'?1:0;
            $user_id = Auth::user()->id;
            $fname = Auth::user()->name;
            $lname = Auth::user()->lname;
            $mobile = Auth::user()->mobile;
            $email = Auth::user()->email;

            $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
            $order = $api->order->create(array( 
                'amount' => $amount * 100, 
                'payment_capture' => 1, 
                'currency' => 'INR' 
            ));
            $rzp_order_id = $order['id'];
            $response=[
                'orderId'=>$rzp_order_id,
                'bed_id'=>$bed_id,
                'razorpayId'=>env('RAZOR_KEY'),
                'amount'=>$amount * 100, 
                'check'=>$check, 
                'name'=>Auth::user()->name.' '.Auth::user()->lname,
                'currency'=>'INR',
                'email'=>Auth::user()->email,
                'mobile'=>Auth::user()->mobile,
                'description'=>'Booking Bed',
                'wallet_price' => $wallet_price,
                'coupon_code' => $request->coupon,
                'coupon_price' => $coupon_price,
                'source' => $source,
            ];
            return view('payment.payment-processing-for-bed',compact('response'));      
        }
    }

    public function payment_complete_for_bed(Request $request)
    {
        $amount = $request->pay_amount;
        $bed_id = $request->bed_id;
        $check = $request->check;
        $wallet_price = $request->wallet_price;
        $coupon_code = $request->coupon_code;
        $coupon_price = $request->coupon_price;
        $source = $request->source;

        $signatureStatus= $this->SignatureVerify(
            $request->all()['rzp_signature'],
            $request->all()['rzp_paymentid'],
            $request->all()['rzp_orderid']
        );
        if($signatureStatus==true)
        {
            $payorderid=$request->all()['rzp_orderid'];
            $paymentid=$request->all()['rzp_paymentid'];
            $signature_id=$request->all()['rzp_signature'];  

            $bed = Bed::find($request->bed_id);

            $UserOrder = new UserOrder();
            $UserOrder->orderId = $payorderid;
            $UserOrder->user_id = auth()->user()->id;
            $UserOrder->transaction_id = $paymentid;
            $UserOrder->source = $source;
            $UserOrder->wallet_deduct = $wallet_price;
            $UserOrder->coupon_code = $coupon_code;
            $UserOrder->coupon_price = $coupon_price;
            $UserOrder->online_paid = $request->pay_amount;
            $UserOrder->total_price = $bed->price;
            $UserOrder->type = 'bed';
            $UserOrder->status = 'completed';
            if($UserOrder->save()){
                $UserBookedBed = new UserBookedBed();
                $UserBookedBed->user_id = auth()->user()->id;
                $UserBookedBed->bed_id = $request->bed_id;
                $UserBookedBed->order_id = $UserOrder->id;
                $UserBookedBed->price = $bed->price;
                $UserBookedBed->booking_status = 'Confirm';
                $UserBookedBed->save();
            }
            if($check==1)
            {
                $wallet = getUserWallet(auth()->user()->id);
                $wallet->amount = 0;
                if($wallet->save()){
                    $walletTransaction = new UserWalletTransaction();
                    $walletTransaction->wallet_id = $wallet->id;
                    $walletTransaction->order_id = $UserOrder->id; 
                    $walletTransaction->transaction_amount = $UserOrder->wallet_deduct;
                    $walletTransaction->description = 'Bed Booking Price!';
                    $walletTransaction->save();
                }
            }

            if($UserOrder->coupon_code!=null)
            {
                $updatecoupon = updateCouponUses($UserOrder->coupon_code);
            }
            $bed->aval_bed = $bed->aval_bed -1 ;
            $bed->save();
        //   $slot = DoctorSlot::find($request->slot_id);
        //   $slot->is_booked = 1;
        //   $slot->save();
          Session::flash('success', 'Your Bed Booked Successfully.');
        }
        return redirect('home');
    }


}
