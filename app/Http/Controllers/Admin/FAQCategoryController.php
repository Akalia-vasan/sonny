<?php

namespace App\Http\Controllers\Admin;

use App\Models\FaqCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FAQCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['faqcategory']=FaqCategory::select('*')->get();
        return view('admin.faq.category.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[];
        return view('admin.faq.category.add',$data);
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
            'name'  => 'required|string',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }  

        $status = $request->status=='on'?1:0;

        $FaqCategory = new FaqCategory;
        $FaqCategory->name  = $request->name;
        $FaqCategory->status = $status;
        $FaqCategory->save();

        return redirect()->route('admin.faqcategory.index')->with('success','FAQ Category Added!');
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
        $data['faqcategory']=FaqCategory::where('id',$id)->first();
        return view('admin.faq.category.edit',$data);
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
            'name'  => 'required|string',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }

        $status = $request->status=='on'?1:0;

        FaqCategory::where('id',$id)->update([
            'name'  => $request->name,
            'status'       => $status,
        ]);

        return redirect()->route('admin.faqcategory.index')->with('success','FAQ Category Update!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $FaqCategory=FaqCategory::find($id);
        if($FaqCategory->delete())
        {
            Session::flash('success','FAQ Category Deleted!');
            return response()->json(['status' => '1','massage'=>'FAQ Category Deleted!']);
        }
        else
        {
            Session::flash('failed','FAQ Category Not Deleted!');
            return response()->json(['status' => '0','massage'=>'FAQ Category Not Deleted!']);
        }
    }
}
