<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bed;
use App\Models\BedType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Support\Facades\Validator;

class BedController extends Controller
{
    public function bedTypeIndex()
    {
        $data['bedtype'] = BedType::all();
        return view('admin.bedtype.index',$data);
    }
    public function bedTypeCreate()
    {
        return view('admin.bedtype.add');
    }
    public function bedTypeEdit($id)
    {
        $data['bedtype'] = BedType::where('id',$id)->first();
        return view('admin.bedtype.edit',$data);
    }
    public function bedTypeStore(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'booking_percentage' => 'required|numeric|min:1',
        ]);
        if($validator->fails())
        {
        	return redirect()->back()->withErrors($validator->errors())->withInput();
        } 
            
        $bedtype = new BedType();
        $bedtype->bed_type = $request->name;
        $bedtype->booking_percentage = $request->booking_percentage;
        $bedtype->save();
        return redirect()->route('admin.bedtype.index')->with('success','Bed Category Added!');
    }
    public function bedTypeUpdate(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'booking_percentage' => 'required|numeric|min:1',
        ]);
        if($validator->fails())
        {
        	return redirect()->back()->withErrors($validator->errors())->withInput();
        } 
            $bedtype = BedType::where('id',$id)->first();
            $bedtype->bed_type = $request->name; 
            $bedtype->booking_percentage = $request->booking_percentage;   
            $bedtype->save();
        return redirect()->route('admin.bedtype.index')->with('success','Bed Category Updated!');
    }
    public function bedTypeDelete($id)
    {
        $bedtype = BedType::where('id',$id)->first();
        $bedtype->delete();
        return redirect()->route('admin.bedtype.index')->with('success','Bed Category Deleted!');
    }

    public function index()
    {
        $data['bed'] = Bed::all();
        return view('admin.bedbooking.index',$data);
    }
    public function Create()
    {
        $data['bedtype'] = BedType::all();
        $data['hospitals'] = Hospital::all();
        return view('admin.bedbooking.add',$data);
    }
    public function Edit($id)
    {
        $data['bedtype'] = BedType::all();
        $data['hospitals'] = Hospital::all();
        $data['bed'] = Bed::where('id',$id)->first();
        return view('admin.bedbooking.edit',$data);
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
        	return redirect()->back()->withErrors($validator->errors())->withInput();
        } 
            
        $bed = new Bed();
        $bed->hospital_id = $request->hospital_id;
        $bed->bed_type_id = $request->bed_type_id;
        $bed->aval_bed = $request->aval_bed;
        $bed->total_price = $request->price;  
        $bed->price = getPercentage($request->bed_type_id,$request->price);
        $bed->save();
        return redirect()->route('admin.bedbooking.index')->with('success','Bed Added!');
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
        	return redirect()->back()->withErrors($validator->errors())->withInput();
        } 
            $Bed = Bed::where('id',$id)->first();
            $Bed->hospital_id = $request->hospital_id;
            $Bed->bed_type_id = $request->bed_type_id;
            $Bed->aval_bed = $request->aval_bed; 
            $Bed->total_price = $request->price;  
            $Bed->price = getPercentage($request->bed_type_id,$request->price);
            $Bed->save();
        return redirect()->route('admin.bedbooking.index')->with('success','Bed  Updated!');
    }
    public function Delete($id)
    {
        $Bed = Bed::where('id',$id)->first();
        $Bed->delete();
        return redirect()->route('admin.bedbooking.index')->with('success','Bed  Deleted!');
    }


}
