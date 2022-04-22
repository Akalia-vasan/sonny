<?php

namespace App\Http\Controllers\Patient;

use Illuminate\Http\Request;
use App\Models\UserMedicalDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MedicalDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['detail']= UserMedicalDetail::where('user_id',Auth::user()->id)->get();                 
        return view('patient.medical_detail',$data);
    }

    public function getData(Request $request)
    {
        $data= UserMedicalDetail::where('id',$request->id)->first();                 
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
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
            'BMI' => 'required|numeric',
            'heart_rate' => 'required|numeric',
            'weight' => 'required|numeric',
            'FBC' => 'required|string|max:255',
            'date' => 'required|string',
            ]
        );
        if($validator->fails())
        {
        	return redirect()->back()->withErrors($validator->errors());
        }
        $user = new UserMedicalDetail;
        $user->user_id =  Auth::user()->id;
        $user->BMI =  $request->BMI;
        $user->heart_rate =  $request->heart_rate;
        $user->weight =  $request->weight;
        $user->FBC =  $request->FBC;
        $user->date =  $request->date;
        if($user->save())
            {
                Session::flash('success', 'Your Medical Detail Added Successfully!');
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
        $validator = Validator::make($request->all(),[
            'BMI' => 'required|numeric',
            'heart_rate' => 'required|numeric',
            'weight' => 'required|numeric',
            'FBC' => 'required|string|max:255',
            'date' => 'required|string',
            ]
        );
        if($validator->fails())
        {
        	return redirect()->back()->withErrors($validator->errors());
        }
        $user = UserMedicalDetail::find($id);
        $user->BMI =  $request->BMI;
        $user->heart_rate =  $request->heart_rate;
        $user->weight =  $request->weight;
        $user->FBC =  $request->FBC;
        $user->date =  $request->date;
        if($user->update())
            {
                Session::flash('success', 'Your Medical Detail Updated Successfully!');
            }
        
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $UserMedicalDetail = UserMedicalDetail::find($id);
        
        if($UserMedicalDetail->delete())
        {
            Session::flash('success','Medical Detail Deleted!');
            return response()->json(['status' => '1','massage'=>'Medical Detail Deleted!']);
        }
        else
        {
            Session::flash('failed','Medical Detail Not Deleted!');
            return response()->json(['failed' => '1','massage'=>'Medical Detail Not Deleted!']);
        }
    }
}
