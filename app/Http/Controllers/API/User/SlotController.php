<?php

namespace App\Http\Controllers\API\User;

use Carbon\Carbon;
use App\Models\User;
use Razorpay\Api\Api;
use App\Models\Doctor;
use App\Models\Voucher;
use App\Models\UserOrder;
use App\Models\DoctorSlot;
use Illuminate\Http\Request;
use App\Models\UserBookedSlot;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\UserWalletTransaction;
use Illuminate\Validation\ValidationException;

class SlotController extends Controller
{
    public function check_promocode(Request $request)
    {
        $data = $request->validate([
            'promo_code'=>'required|exists:vouchers,code', 
            'slot_id'=>'required||exists:doctor_slots,id',      
        ]);
        $voucher = Voucher::where('code',$data['promo_code'])->first();
        $slot = DoctorSlot::where('id',$data['slot_id'])->first();
        $userdata=User::where('id',auth()->user()->id)->first();
        $doctor = Doctor::where('id',$slot->doctor_id)->first();
        if(date('Y-m-d') >= $slot->booking_date)
        {
            throw ValidationException::withMessages([
                'slot_id' => ['Please Select Upconing Slots !.'],
            ]);
        }
        if($slot->is_booked==1)
        {
            throw ValidationException::withMessages([
                'slot_id' => ['Slot Already Booked!.'],
            ]);
        }

        if($voucher)
        {
            if($voucher->max_uses>$voucher->used)
            {
                if ((date('Y-m-d') >= $voucher->valid_from) && (date('Y-m-d') <= $voucher->valid_to)){ 
                    if($voucher->value>$doctor->price)
                    { 
                        // dd($voucher->value);
                        return res_failed('Amount Is Lower, Promocode Not Applicable!');   
                    }
                    $data=[];  
                    $discount=0;
                    $new_price=$doctor->price;
                    $discount  = $voucher->value;
                    $new_price = $doctor->price-$discount;
                    // $data['slot'] = $slot;
                    $data['promocode'] = $voucher->code;
                    $data['discount']  = $discount;
                    $data['new_price']  = $new_price>0?$new_price:0;
                    return res_success('Success',$data);
                }
                return res_failed('Coupon Code Expired!');                       
            }
            return res_failed('Coupon Code Not Applicable!');
        }
        return res_failed();
    }

    public function getWallet(Request $request)
    {
        $wallet = getUserWallet(auth()->user()->id);
        if($wallet)
        {
            $data=[];  
            $data['wallet_id'] = $wallet->id;
            $data['wallet_amount']  = $wallet->amount;
            return res_success('Success',$data);
        }
        return res_failed();
    }

    public function createOrder(Request $request)
    {
        $data = $request->validate([
            'promo_code'=>'sometimes|exists:vouchers,code', 
            'slot_id'=>'required||exists:doctor_slots,id',      
        ]);
        $voucher = Voucher::where('code',$request->promo_code)->first();
        $slot = DoctorSlot::where('id',$data['slot_id'])->first();
        $userdata=User::where('id',auth()->user()->id)->first();
        $doctor = Doctor::where('id',$slot->doctor_id)->first();
        $wallet = getUserWallet(auth()->user()->id);
        if(date('Y-m-d') >= $slot->booking_date)
        {
            throw ValidationException::withMessages([
                'slot_id' => ['Please Select Upconing Slots !.'],
            ]);
        }
        if($slot->is_booked==1)
        {
            throw ValidationException::withMessages([
                'slot_id' => ['Slot Already Booked!.'],
            ]);
        }
        $discount=0;
        $new_price=$doctor->price;
        $coupon_price = 0;
        $wallet_price = 0;
        $onlinepaid = $new_price;
        if($voucher)
        {
            if($voucher->max_uses>$voucher->used)
            {
                if ((date('Y-m-d') >= $voucher->valid_from) && (date('Y-m-d') <= $voucher->valid_to)){ 
                    if($voucher->value>$doctor->price)
                    { 
                        return res_failed('Amount Is Lower, Promocode Not Applicable!');   
                    }
                    $data=[];  
                    $discount  = $voucher->value;
                    $new_price = $doctor->price-$discount;
                    if($request->use_wallet==1){
                        if($wallet->amount>=$new_price){
                            $new_price = 0;
                            $coupon_price = 0;
                            $wallet_price = $wallet->amount-$new_price;
                            $onlinepaid = 0;
                        }else{
                            $new_price = $new_price-$wallet->amount;
                            $coupon_price = 0;
                            $wallet_price = $wallet->amount;
                            $onlinepaid = $new_price;
                        }
                    }
                }else{
                    return res_failed('Coupon Code Expired!'); 
                }                      
            }else{
                return res_failed('Coupon Code Not Applicable!');
            }
        }else{
            if($request->use_wallet==1){
                if($wallet->amount>=$new_price){
                    $new_price = 0;
                    $coupon_price = 0;
                    $wallet_price = $wallet->amount-$new_price;
                    $onlinepaid = 0;
                }else{
                    $new_price = $new_price-$wallet->amount;
                    $coupon_price = 0;
                    $wallet_price = $wallet->amount;
                    $onlinepaid = $new_price;
                }
            }
        }

        if($new_price==0){

            $tid = 'Order_'.time();
            $UserOrder = new UserOrder();
            $UserOrder->orderId = $tid;
            $UserOrder->user_id = auth()->user()->id;
            $UserOrder->transaction_id = $tid;
            $UserOrder->source = 'online';
            $UserOrder->wallet_deduct = $wallet_price;
            $UserOrder->coupon_code = $request->promo_code;
            $UserOrder->coupon_price = $coupon_price;
            $UserOrder->online_paid = $onlinepaid;
            $UserOrder->total_price = $doctor->price;
            $UserOrder->type = 'slot';
            $UserOrder->status = 'completed';
            if($UserOrder->save()){
                $userBookedSlot = new UserBookedSlot();
                $userBookedSlot->user_id = auth()->user()->id;
                $userBookedSlot->doctor_id = $doctor->id;
                $userBookedSlot->slot_id = $request->slot_id;
                $userBookedSlot->order_id = $UserOrder->id;
                $userBookedSlot->price = $doctor->price;
                $userBookedSlot->booking_status = 'Pending';
                $userBookedSlot->save();
            }
            if($request->use_wallet==1){
                $wallet = getUserWallet(auth()->user()->id);
                $wallet->amount = $wallet->amount - $wallet_price;
                if($wallet->save()){
                    $walletTransaction = new UserWalletTransaction();
                    $walletTransaction->wallet_id = $wallet->id;
                    $walletTransaction->order_id = $UserOrder->id; 
                    $walletTransaction->transaction_amount = $wallet_price;
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
            return res_success('Slot Booked',['order_id'=>$tid]);
        }else{
            $totalamount=$new_price;
            $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
                $order = $api->order->create(array( 
                    'amount' => $totalamount * 100, 
                    'payment_capture' => 1, 
                    'currency' => 'INR' 
                ));
            $orderId = $order['id'];

            $UserOrder = new UserOrder();
            $UserOrder->orderId = $orderId;
            $UserOrder->user_id = auth()->user()->id;
            $UserOrder->transaction_id = $orderId;
            $UserOrder->source = 'online';
            $UserOrder->wallet_deduct = $wallet_price;
            $UserOrder->coupon_code = $request->promo_code;
            $UserOrder->coupon_price = $coupon_price;
            $UserOrder->online_paid = $onlinepaid;
            $UserOrder->total_price = $doctor->price;
            $UserOrder->type = 'slot';
            $UserOrder->status = 'pending';
             if($UserOrder->save()){
                $userBookedSlot = new UserBookedSlot();
                $userBookedSlot->user_id = auth()->user()->id;
                $userBookedSlot->doctor_id = $doctor->id;
                $userBookedSlot->slot_id = $request->slot_id;
                $userBookedSlot->order_id = $UserOrder->id;
                $userBookedSlot->price = $doctor->price;
                $userBookedSlot->booking_status = 'Pending';
                $userBookedSlot->save();
            }
            
            if($request->use_wallet==1){
                $wallet = getUserWallet(auth()->user()->id);
                $wallet->amount = $wallet->amount - $wallet_price;
                if($wallet->save()){
                    $walletTransaction = new UserWalletTransaction();
                    $walletTransaction->wallet_id = $wallet->id;
                    $walletTransaction->order_id = $UserOrder->id; 
                    $walletTransaction->transaction_amount = $wallet_price;
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
            if($orderId)
            {
                $response=[
                    'razorpay_key'=>env('RAZOR_KEY'),
                    'currency'=>'INR',
                    'name'=>"HospirentOnline",
                    'description'=>'Order By Hospirent',
                    'image'=>url('img/logo.png'),
                    'amount'=>$totalamount, 
                    'orderId'=>$orderId,
                    'username'=>auth()->user()->name,
                    'email'=>auth()->user()->email,
                    'mobile'=>auth()->user()->mobile,
                    'promo_code'=>$request->promo_code,
                ];
                return res_success('Success!',$response);
            }
            res_failed('Your Order Not Created');
        }
    }


    public function PaymentComplete(Request $request)
    {
        Log::debug('productPaymentComplete', ['request' => $request->all()]);
        $data = $request->validate([
            'rzp_orderid'=>'required',
            'rzp_paymentid'=>'required',
            'rzp_signature'=>'required',
        ]);
        
        $rzp_orderId=$request->input('rzp_orderid');
        $rzp_paymentId=$request->input('rzp_paymentid');
        $rzp_signatureId=$request->input('rzp_signature');

        
        $UserOrder = UserOrder::where('orderId',$rzp_orderId)->first();
        $signatureStatus= $this->SignatureVerify($rzp_signatureId,$rzp_paymentId,$rzp_orderId);
        if(empty($UserOrder))
        {
            return res_failed('Invalid Order Id!');
        }
        if($signatureStatus==true)
        {
            $UserOrder->status = 'Completed';
            $UserOrder->save();
            
            return res_success('Payment Success',['order_id'=>$rzp_orderId]);
        }
        if($signatureStatus==false)
        {

            $UserOrder->order_status = 'Failed';
            $UserOrder->save();

            $voucher = Voucher::where('code', $UserOrder->coupon_code)->first();
            if($voucher)
            {
                $voucher->used = $voucher->used - 1;
                $voucher->save();
            }
            if($UserOrder->wallet_deduct>0)
            {
                $wallet = getUserWallet(auth()->user()->id);
                $wallet->amount = $wallet->amount + $UserOrder->wallet_deduct;
                if($wallet->save()){
                    $walletTransaction = new UserWalletTransaction();
                    $walletTransaction->wallet_id = $wallet->id;
                    $walletTransaction->order_id = $UserOrder->id; 
                    $walletTransaction->transaction_amount = $UserOrder->wallet_deduct;
                    $walletTransaction->description = 'Slot Booking Refund Order Failed!';
                    $walletTransaction->save();
                }
            }
            
            return res_failed('Payment Failed',['order_id'=>$rzp_orderId]);
        }
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
        catch (\Exception $e) {
            return false;
        }
    }

    public function getAppointment()
    {
        $appointments = UserBookedSlot::where('user_id',auth()->user()->id)->get();
        if($appointments)
        {    
            $data  = [];
            foreach($appointments as $appointment){
                $data[] = [
                    'id'   =>    $appointment->id,
                    'doctor_name'   =>    $appointment->getdoctorbooked->name.' '.$appointment->getdoctorbooked->l_name,
                    'doctor_image'   =>    $appointment->getdoctorbooked->profile_image,
                    'doctor_speciality'   =>    $appointment->getdoctorbooked->getspeciality->sp_name,
                    'appointment_date'   =>    Carbon::parse($appointment->getslotbooked->booking_date)->format('d M Y'),
                    'appointment_time'   =>    Carbon::parse($appointment->getslotbooked->start_time)->format('H:i A'),
                    'booking_date'   =>    Carbon::parse($appointment->created_at)->format('d M Y'),
                    'price'   =>    $appointment->price,
                    'coupon_price'   =>    $appointment->getOrder->coupon_price,
                    'wallet_deduct'   =>    $appointment->getOrder->wallet_deduct,
                    'booking_status'   =>    $appointment->booking_status,
                ];
            }
            return res_success('SUCCESS!',['Appontments'=>$data]);
        }
        return res_failed('Data Not Saved!');
    }
}
