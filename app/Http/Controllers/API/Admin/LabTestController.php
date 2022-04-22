<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\LabTest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LabTestController extends Controller
{

    function __construct()
    { 
        $this->middleware('permission:labtest-list|labtest-create|labtest-edit|labtest-delete', ['only' => ['index','store']]);
        $this->middleware('permission:labtest-create', ['only' => ['create','store']]);
        $this->middleware('permission:labtest-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:labtest-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['test']=LabTest::get();
        return res_success('Success!',['data'=> $data]);
    }
    public function create()
    {
        $data=[];
        return res_success('Success!',['data'=> $data]);
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'test_name' => 'required|string|max:255',
        ]);
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        }   
        $test = new LabTest;
        $test->test_name = $request->test_name;
        $test->save();
        return res_success('Success!',['data'=> $test]);
    }
    public function edit($id)
    {
        $data['edittest']=LabTest::where('id',$id)->first();
        return res_success('Success!',['data'=> $data]);
    }
    public function update(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'test_name' => 'required|string|max:255',
        ]);
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        } 
        $test = LabTest::where('id',$id)->first();
        $test->test_name = $request->test_name;
        $test->save();
        return res_success('Success!',['data'=> $test]);
    }
    public function destroy($id)
    {
        $test = LabTest::where('id',$id)->first();
        $test->delete();
        return res_success('Success!',['data'=> '']);
    }
}
