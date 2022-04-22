<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.lab-test.index',$data);
    }
    public function create()
    {
        $data=[];
        return view('admin.lab-test.add',$data);
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'test_name' => 'required|string|max:255',
        ]);
        if($validator->fails())
        {
        	return redirect()->back()->withErrors($validator->errors())->withInput();
        }   
        $test = new LabTest;
        $test->test_name = $request->test_name;
        $test->save();
        return redirect()->route('admin.lab_test.index')->with('success','Lab Test Added!');
    }
    public function edit($id)
    {
        $data['edittest']=LabTest::where('id',$id)->first();
        return view('admin.lab-test.edit',$data);
    }
    public function update(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'test_name' => 'required|string|max:255',
        ]);
        if($validator->fails())
        {
        	return redirect()->back()->withErrors($validator->errors())->withInput();
        } 
        $test = LabTest::where('id',$id)->first();
        $test->test_name = $request->test_name;
        $test->save();
        return redirect()->route('admin.lab_test.index')->with('success','Lab Test Updated!');
    }
    public function destroy($id)
    {
        $test = LabTest::where('id',$id)->first();
        $test->delete();
        return redirect()->route('admin.lab_test.index')->with('success','Lab Test Deleted!');
    }
}
