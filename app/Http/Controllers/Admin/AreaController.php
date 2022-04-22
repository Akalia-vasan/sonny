<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:area-list|area-create|area-edit|area-delete', ['only' => ['index','store']]);
        $this->middleware('permission:area-create', ['only' => ['create','store']]);
        $this->middleware('permission:area-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:area-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['area']=Area::get();
        return view('admin.area.index',$data);
    }
    public function create()
    {
        $data=[];
        return view('admin.area.add',$data);
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
        	return redirect()->back()->withErrors($validator->errors())->withInput();
        }   
        $Area = new Area;
        $Area->area = $request->area;
        $Area->link = $request->link;
        $Area->location = $request->location;
        $Area->lattitude = $request->address_latitude;
        $Area->longitude = $request->address_longitude;
        $Area->save();
        return redirect()->route('admin.area.index')->with('success','Area Added!');
    }
    public function edit($id)
    {
        $data['editarea']=Area::where('id',$id)->first();
        return view('admin.area.edit',$data);
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
        	return redirect()->back()->withErrors($validator->errors())->withInput();
        } 
        $area = Area::where('id',$id)->first();
        $area->area = $request->area;
        $area->link = $request->link;;
        $area->location = $request->location;
        $area->lattitude = $request->address_latitude;
        $area->longitude = $request->address_longitude;
        $area->save();
        return redirect()->route('admin.area.index')->with('success','Area Updated!');
    }
    public function destroy($id)
    {
        $Speciality = Area::where('id',$id)->first();
        $Speciality->delete();
        return redirect()->route('admin.area.index')->with('success','Area Deleted!');
    }

    public  function generateRandomString($length = 20) 
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
