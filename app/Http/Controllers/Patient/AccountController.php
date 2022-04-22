<?php

namespace App\Http\Controllers\Patient;

use App\Models\User;
use App\Models\UserPayout;
use Illuminate\Http\Request;
use App\Models\DoctorFeedback;
use App\Http\Controllers\Controller;
use App\Models\UserWallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['wallet']= getUserWallet(Auth::user()->id);
        $data['earning']= UserPayout::where('user_id',Auth::user()->id)
                          ->where('status',1)->sum('amount');
        $data['requested']= UserPayout::where('user_id',Auth::user()->id)
                            ->where('status',0)->sum('amount');
        $data['payout']= UserPayout::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->get();
                          
        return view('patient.account',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        	return redirect()->back()->withErrors($validator->errors());
        }
        $user = User::find(Auth::user()->id);
        $user->bank_name =  $request->bank_name;
        $user->ifsc_code =  $request->ifsc_code;
        $user->account =  $request->account;
        $user->account_name =  $request->account_name;
        if($user->save())
            {
                Session::flash('success', 'Your Account Detail Updated Successfully!');
            }
        
        return redirect()->back();
    }

    public function payout(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'amount' => 'required|numeric',        
            ]
        );
        if($validator->fails())
        {
        	return redirect()->back()->withErrors($validator->errors());
        }
        $payout =  new UserPayout();
        $payout->amount =  $request->amount;
        $payout->user_id =  Auth::user()->id;
        if($payout->save())
            {
                Session::flash('success', 'Your Payout Request Added Successfully!');
            }
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
