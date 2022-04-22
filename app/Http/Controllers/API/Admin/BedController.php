<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Bed;
use App\Models\BedType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Support\Facades\Validator;

class BedController extends Controller
{
    public function index()
    {
        $data['bed'] = Bed::all();
        return res_success('Success!',['data'=> $data]);
    }
    public function Create()
    {
        $data['bedtype'] = BedType::all();
        $data['hospitals'] = Hospital::all();
        return res_success('Success!',['data'=> $data]);
    }
    public function Edit($id)
    {
        $data['bedtype'] = BedType::all();
        $data['hospitals'] = Hospital::all();
        $data['bed'] = Bed::where('id',$id)->first();
        return res_success('Success!',['data'=> $data]);
    }
    public function Store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'hospital_id' => 'required|exists:hospitals,id',
            'bed_type_id' => 'required|exists:bed_types,id',
            'aval_bed' => 'required|integer|not_in:0',
            'price' => 'required|integer|not_in:0',
        ]);
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        } 
            
        $bed = new Bed();
        $bed->hospital_id = $request->hospital_id;
        $bed->bed_type_id = $request->bed_type_id;
        $bed->aval_bed = $request->aval_bed;
        $bed->total_price = $request->price;  
        $bed->price = getPercentage($request->bed_type_id,$request->price);
        $bed->save();
        return res_success('Success!',['data'=> $bed]);
    }
    public function Update(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'hospital_id' => 'required|exists:hospitals,id',
            'bed_type_id' => 'required|exists:bed_types,id',
            'aval_bed' => 'required|integer|not_in:0',
            'price' => 'required|integer|not_in:0',
        ]);
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        } 
        $Bed = Bed::where('id',$id)->first();
        $Bed->hospital_id = $request->hospital_id;
        $Bed->bed_type_id = $request->bed_type_id;
        $Bed->aval_bed = $request->aval_bed; 
        $Bed->total_price = $request->price;  
        $Bed->price = getPercentage($request->bed_type_id,$request->price);
        $Bed->save();
        return res_success('Success!',['data'=> $Bed]);
    }
    public function destroy($id)
    {
        $Bed = Bed::where('id',$id)->first();
        $Bed->delete();
        return res_success('Success!',['data'=> '']);
    }


}