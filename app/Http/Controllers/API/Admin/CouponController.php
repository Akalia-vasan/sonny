<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:coupon-list|coupon-create|coupon-edit|coupon-delete', ['only' => ['index','store']]);
        $this->middleware('permission:coupon-create', ['only' => ['create','store']]);
        $this->middleware('permission:coupon-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:coupon-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['allcoupon'] = Voucher::select('*')->orderBy('id','desc')->get();
        return res_success('Success!',['data'=> $data]);
    }
    public function create()
    {
        $data = [];
        return res_success('Success!',['data'=> $data]);
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'code'       => 'required|min:8|string|unique:vouchers',
            'valid_from'   => 'required|after:yesterday|date_format:Y-m-d',
            'valid_to'    => 'required|after:valid_from|date_format:Y-m-d',
            'type'         => 'required',
            'value'         => 'required',
            'max_uses'         => 'required',
        ]);
        if($validator->fails())
        {
            return res_failed($validator->errors());
        } 
        
        $Voucher = new Voucher;
        $Voucher->code          = strtoupper($request->code);
        $Voucher->valid_from    = $request->valid_from;
        $Voucher->valid_to      = $request->valid_to;
        $Voucher->discount_type = $request->type;
        $Voucher->value         = $request->value;
        $Voucher->max_uses      = $request->max_uses ? $request->max_uses : 0 ;
        $Voucher->description         = $request->description;
        $Voucher->save();

        return res_success('Success!',['data'=> $Voucher]);
    }

    public function edit($id)
    {
        $data['editcoupon'] = Voucher::where('id',$id)->first();
        return res_success('Success!',['data'=> $data]);
    }

    public function update(Request $request, $id)
    {
        $validator=Validator::make($request->all(),[
            'code'       => "required|string|unique:vouchers,code,$id",
            'valid_from'   => 'required|after:yesterday|date_format:Y-m-d',
            'valid_to'    => 'required|after:valid_from|date_format:Y-m-d',
            'value'         => 'required',
            'max_uses'         => 'required',
        ]);
        if($validator->fails())
        {
            return res_failed($validator->errors());
        }  
        $EditVoucher = Voucher::where('id',$id)->first();
        $EditVoucher->code          = strtoupper($request->code);
        $EditVoucher->valid_from    = $request->valid_from;
        $EditVoucher->valid_to      = $request->valid_to;
        $EditVoucher->value         = $request->value;
        $EditVoucher->max_uses      = $request->max_uses ? $request->max_uses : 0 ;
        $EditVoucher->description         = $request->description;
        $EditVoucher->save();

        return res_success('Success!',['data'=> $EditVoucher]);
    }

    public function destroy($id)
    {
        $voucher = Voucher::find($id);
        if($voucher->used == '0')
        {
            $voucher->delete();
            return res_success('Success!',['data'=> 'Coupon Deleted!']);
        }
        else
        {
            return res_failed('Coupon Not Deleted!');
        }
    }
}
