<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    public function index()
    {
        $areaList = Area::get();

        return res_success('Success!',['areas'=>$areaList]);
    }

    public function create()
    {
        $data = [];

        return res_success('Success!',['areas'=>$data]);
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'area' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'address_latitude' => 'required|string|max:255',
            'address_longitude' => 'required|string|max:255',
        ]);
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        }   
        $Area = new Area;
        $Area->area = $request->area;
        $Area->link = $request->link;
        $Area->location = $request->location;
        $Area->lattitude = $request->address_latitude;
        $Area->longitude = $request->address_longitude;
        $Area->save();

        return res_success('Success!',['Area'=>$Area]);
    }

    public function edit($id)
    {
        $data = Area::where('id',$id)->first();

        return res_success('Success!',['areas'=>$data]);
    }

    public function update(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'area' => 'required|string|max:255',
            'link' => 'required|string||max:255',
            'location' => 'required|string|max:255',
            'address_latitude' => 'required|string|max:255',
            'address_longitude' => 'required|string|max:255',
        ]);
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        } 
        $area = Area::where('id',$id)->first();
        $area->area = $request->area;
        $area->link = $request->link;;
        $area->location = $request->location;
        $area->lattitude = $request->address_latitude;
        $area->longitude = $request->address_longitude;
        $area->save();

        return res_success('Success!',['Area' => $area]);
    }

    public function destroy($id)
    {
        $Speciality = Area::where('id',$id)->first();
        $Speciality->delete();

        return res_success('Success!',['Area' => 'Area Deleted!']);
    }

}