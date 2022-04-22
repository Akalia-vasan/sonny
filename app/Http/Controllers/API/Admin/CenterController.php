<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Center;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CenterController extends Controller
{
    
    public function index()
    {
        $data = [];
        return res_success('Success!',['data'=> $data]);
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
    
    public function create()
    {
        $data = [];
        return res_success('Success!',['data'=> $data]);
    }

    
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'center_name'       => 'required|string',
            'address_latitude'  => 'required|not_in:0',
            'address_longitude' => 'required|not_in:0',
        ]);
        if($validator->fails())
        {
            return res_failed($validator->errors());
        }  
        if($request->status == 'on')
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

        return res_success('Success!',['data'=> $addcenter]);
    }

    public function edit($id)
    {
        $data['allcenter'] = Center::where('id',$id)->first();
        return res_success('Success!',['data'=> $data]);
    }

    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'center_name'       => 'required|string',
            'address_latitude'  => 'required|not_in:0',
            'address_longitude' => 'required|not_in:0',
        ]);
        if($validator->fails())
        {
            return res_failed($validator->errors());
        }  
        if($request->status == 'on')
        {
            $status = 1;
        }
        else 
        {
            $status = 0;
        }
        Center::where('id',$id)->update([
            'center_name'  => $request->center_name,
            'lattitude'    => $request->address_latitude,
            'longitude'    => $request->address_longitude,
            'active'       => $status,
        ]);

        return res_success('Success!',['data'=> '']);
    }

    public function destroy($id)
    {
        $center = Center::find($id);
        if($center->delete())
        {
            return res_success('Success!',['status' => '1']);
        }
        else
        {
            return res_success('Success!',['status' => '0']);
        }
    }
}
