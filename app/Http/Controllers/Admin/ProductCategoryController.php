<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['productcategory']=ProductCategory::select('*')->get();
        return view('admin.product.category.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[];
        return view('admin.product.category.add',$data);
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
            'category_name'  => 'required|string',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }  

        $status = $request->status=='on'?1:0;

        $ProductCategory = new ProductCategory;
        $ProductCategory->category_name  = $request->category_name;
        $ProductCategory->active       = $status;
        $ProductCategory->save();

        return redirect()->route('admin.category.index')->with('success','Product Category Added!');
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
        $data['productcategory']=ProductCategory::where('id',$id)->first();
        return view('admin.product.category.edit',$data);
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
            'category_name'  => 'required|string',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }

        $status = $request->status=='on'?1:0;

        ProductCategory::where('id',$id)->update([
            'category_name'  => $request->category_name,
            'active'       => $status,
        ]);

        return redirect()->route('admin.category.index')->with('success','Product Category Update!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ProductCategory=ProductCategory::find($id);
        if($ProductCategory->delete())
        {
            Session::flash('success','Product Category Deleted!');
            return response()->json(['status' => '1','massage'=>'Product Category Deleted!']);
        }
        else
        {
            Session::flash('failed','Product Category Not Deleted!');
            return response()->json(['status' => '0','massage'=>'Product Category Not Deleted!']);
        }
    }
}
