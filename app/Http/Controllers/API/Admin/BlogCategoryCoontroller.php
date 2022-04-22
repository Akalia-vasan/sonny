<?php

namespace App\Http\Controllers\API\Admin;

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
        $data['allcategory'] = BlogCategory::all();

        return res_success('Success!',['data'=> $data]);
    }

    public function create()
    {
        $data = [];
        return res_success('Success!',['data'=> $data]);
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'category_name'       => 'required|string',
        ]);
        if($validator->fails())
        {
            return res_failed($validator->errors());
        }
        $addcat = new BlogCategory;
        $addcat->category_name  = $request->category_name;
        $addcat->save();

        return res_success('Success!',['data'=> $addcat]);
    }

    public function edit($id)
    {
        $data['category'] = BlogCategory::where('id',$id)->first();
        return res_success('Success!',['data'=> $data]);
    }

    public function update(Request $request, $id)
    {
        $validator=Validator::make($request->all(),[
            'category_name'       => 'required|string',
        ]);
        if($validator->fails())
        {
            return res_failed($validator->errors());
        }  
        BlogCategory::where('id',$id)->update([
            'category_name'  => $request->category_name,
        ]);

        return res_success('Success!',['data'=> '']);
    }

    public function destroy($id)
    {
        $cat=BlogCategory::find($id);
        if($cat->delete())
        {
            return res_success('Success!',['data'=> '']);
        }
        else
        {
            return res_failed('fail');
        }
    }
}
