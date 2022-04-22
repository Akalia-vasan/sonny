<?php

namespace App\Http\Controllers\Admin;

use App\Models\Center;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=[];
        return view('admin.center.index',$data);
    }

    public function get(Request $request)
    {
        $query = Center::select('*');

        return datatables()->of($query)
        ->addColumn('action', function ($row) {
            $html = "<a class='btn btn-xs text-light btn-primary'  href='". route('admin.center.edit', $row->id) ."'><i class=' fa fa-pencil'></i></a> ";            
            $html .="<button id='$row->id' class='btn btn-xs btn-success' onclick='mydeleteCenter($row->id)'><i class=' fa fa-trash'></i></button>";
            return $html;
        })
        ->toJson();
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[];
        return view('admin.center.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'center_name'       => 'required|string',
            'address_latitude'  => 'required|not_in:0',
            'address_longitude' => 'required|not_in:0',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }  
        if($request->status=='on')
        {
            $status= 1;
        }
        else 
        {
            $status=0;
        }
        $addcenter = new Center;
        $addcenter->center_name  = $request->center_name;
        $addcenter->lattitude    = $request->address_latitude;
        $addcenter->longitude    = $request->address_longitude;
        $addcenter->active       = $status;
        $addcenter->save();

        return redirect()->route('admin.center.index')->with('success','Center Added!');
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
        $data['allcenter']=Center::where('id',$id)->first();
        return view('admin.center.edit',$data);
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
        $validator=Validator::make($request->all(),[
            'center_name'       => 'required|string',
            'address_latitude'  => 'required|not_in:0',
            'address_longitude' => 'required|not_in:0',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }  
        if($request->status=='on')
        {
            $status= 1;
        }
        else 
        {
            $status=0;
        }
        Center::where('id',$id)->update([
            'center_name'  => $request->center_name,
            'lattitude'    => $request->address_latitude,
            'longitude'    => $request->address_longitude,
            'active'       => $status,
        ]);

        return redirect()->route('admin.center.index')->with('success','Center Update!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $center=Center::find($id);
        if($center->delete())
        {
            Session::flash('success','Center Deleted!');
            return response()->json(['status' => '1']);
        }
        else
        {
            Session::flash('failed','Center Not Deleted!');
            return response()->json(['status' => '0']);
        }
    }
}
