<?php

namespace App\Http\Controllers\Patient;

use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\UserMedicalRecord;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['record']= UserMedicalRecord::where('user_id',Auth::user()->id)->get(); 
        $data['prescriptions'] = Prescription::where('user_id',auth()->user()->id)->orderBy('date','DESC')->get();                
        return view('patient.medical_record',$data);
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
            'description' => 'required|string',
            'attachment' => 'required|mimes:pdf',
            'date' => 'required|string',
            ]
        );
        if($validator->fails())
        {
        	return redirect()->back()->withErrors($validator->errors());
        }
        $user = new UserMedicalRecord();
        $user->user_id =  Auth::user()->id;
        $user->title =  $request->title;
        $user->patient =  $request->patient;
        $user->description =  $request->description;
        if($request->has('attachment')) 
            {
                $attachment = $request->file('attachment');
                $destinationPath1 ='public/attachment/';
                $attachments = time().'_'.$attachment->getClientOriginalName();
                $upload_success1 = $request->file('attachment')->storeAs('public/attachment',$attachments);    
                $uploaded_attachment = 'attachment/'.$attachments; 
                $user->attachment =  $uploaded_attachment;
            
            }
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
        $UserMedicalRecord = UserMedicalRecord::find($id);
        
        if($UserMedicalRecord->delete())
        {
            Session::flash('success','Medical Record Deleted!');
            return response()->json(['status' => '1','massage'=>'Medical Record Deleted!']);
        }
        else
        {
            Session::flash('failed','Medical Record Not Deleted!');
            return response()->json(['failed' => '1','massage'=>'Medical Record Not Deleted!']);
        }
    }
}
