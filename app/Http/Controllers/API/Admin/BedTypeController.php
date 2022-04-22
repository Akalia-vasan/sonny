<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Bed;
use App\Models\BedType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Support\Facades\Validator;

class BedTypeController extends Controller
{
    public function index()
    {
        $bedtypes = BedType::all();

        return res_success('Success!',['data'=> $bedtypes]);
    }
    public function create()
    {
        $data = [];
        return res_success('Success!',['data'=> $data]);
    }
    public function edit($id)
    {
        $data['bedtype'] = BedType::where('id',$id)->first();
        return res_success('Success!',['data'=> $data]);
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'booking_percentage' => 'required|numeric|min:1',
        ]);
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        } 
            
        $bedtype = new BedType();
        $bedtype->bed_type = $request->name;
        $bedtype->booking_percentage = $request->booking_percentage;
        $bedtype->save();
        return res_success('Success!',['data'=> $bedtype]);
    }
    public function update(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'booking_percentage' => 'required|numeric|min:1',
        ]);
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        } 
        $bedtype = BedType::where('id',$id)->first();
        $bedtype->bed_type = $request->name; 
        $bedtype->booking_percentage = $request->booking_percentage;   
        $bedtype->save();
        return res_success('Success!',['data'=> $bedtype]);
    }
    public function delete($id)
    {
        $bedtype = BedType::where('id',$id)->first();
        $bedtype->delete();
        return res_success('Success!',['data'=> '']);
    }

}
