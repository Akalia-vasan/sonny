<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BlogCategoryCoontroller extends Controller
{
    
    function __construct()
    {
        $this->middleware('permission:blogtype-list|blogtype-create|blogtype-edit|blogtype-delete', ['only' => ['index','store']]);
        $this->middleware('permission:blogtype-create', ['only' => ['create','store']]);
        $this->middleware('permission:blogtype-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:blogtype-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        // dd('hi');
        $data['allcategory']=BlogCategory::all();
        return view('admin.blog-category.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[];
        return view('admin.blog-category.add',$data);
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
            'category_name'       => 'required|string',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $addcat = new BlogCategory;
        $addcat->category_name  = $request->category_name;
        $addcat->save();

        return redirect()->route('admin.b_category.index')->with('success','Blog Category Added!');
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
        $data['category']=BlogCategory::where('id',$id)->first();
        return view('admin.blog-category.edit',$data);
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
            'category_name'       => 'required|string',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }  
        BlogCategory::where('id',$id)->update([
            'category_name'  => $request->category_name,
        ]);

        return redirect()->route('admin.b_category.index')->with('success','Blog Category Update!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat=BlogCategory::find($id);
        if($cat->delete())
        {
            Session::flash('success','Blog Category Deleted!');
            return redirect()->back();
        }
        else
        {
            Session::flash('failed','Blog Category Not Deleted!');
            return redirect()->back();
        }
    }
}
