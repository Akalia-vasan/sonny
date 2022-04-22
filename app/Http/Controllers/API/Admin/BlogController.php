<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogCoontroller extends Controller
{
    
    function __construct()
    {
        $this->middleware('permission:blog-list|blog-create|blog-edit|blog-delete', ['only' => ['index','store']]);
        $this->middleware('permission:blog-create', ['only' => ['create','store']]);
        $this->middleware('permission:blog-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:blog-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['allblog'] = Blog::where('active',1)->paginate(9);
        return res_success('Success!',['data'=> $data]);
    }

    public function pending()
    {
        $data['allblog'] = Blog::where('active',0)->paginate(9);
        return res_success('Success!',['data'=> $data]);
    }
    
    public function blogComment($id)
    {
        $data['allblog'] = Blog::where('id',$id)->first();
        $data['allblogcomment'] = BlogComment::where('blog_id',$id)->get();
        $data['latestblog'] = Blog::where('active',1)->latest()->limit(5)->get();
        $data['blogcategory'] = Blog::groupBy('category_id')->select('category_id', DB::raw('count(*) as total'))->get();
        return res_success('Success!',['data'=> $data]);
    }

    
    public function create()
    {
        $data['blogcat'] = BlogCategory::all();
        return res_success('Success!',['data'=> $data]);
    }

    
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'category_id'       => 'required|string',
            'blog_title'       => 'required|string',
            'description'       => 'required|string',
            'blog_image'       => 'required|image|mimes:jpg,jpeg,png',
            'video_url'       => 'sometimes|nullable',
        ]);
        if($validator->fails())
        {
            return res_failed($validator->errors());
        }
        if($request->has('blog_image'))
        {
            $backupLoc='public/BlogImages/';
            if(!is_dir($backupLoc)) {
                Storage::makeDirectory($backupLoc, 0755, true, true);
            }
            $name = time().'_'.$request->blog_image->getClientOriginalName();
            Storage::disk('public')->put('BlogImages/'.$name,file_get_contents($request->blog_image),'public');
        }

        if ($request->video_url!=null && strpos($request->video_url, 'watch?v=') !== false) {
            $request->video_url = str_replace('watch?v=','embed/',$request->video_url);
        }

        $addcat = new Blog;
        $addcat->author  = auth()->user()->id;
        $addcat->type  = 'admin';
        $addcat->category_id   = $request->category_id ;
        $addcat->blog_title  = $request->blog_title;
        $addcat->blog_description  = $request->description;
        $addcat->blog_image  = 'BlogImages/'.$name;
        $addcat->video_url  = $request->video_url;
        $addcat->active  = $request->status =='on' ? 1 : 0;
        $addcat->save();

        return res_success('Success!',['data'=> $addcat]);
    }

    public function edit($id)
    {
        $data['blogcat'] = BlogCategory::get();
        $data['editblog'] = Blog::where('id',$id)->first();
        return res_success('Success!',['data'=> $data]);
    }

    
    public function update(Request $request, $id)
    {
        $validator=Validator::make($request->all(),[
            'category_id'       => 'required|string',
            'blog_title'       => 'required|string',
            'description'       => 'required|string',
            'blog_image'       => 'sometimes|nullable|image|mimes:jpg,jpeg,png',
            'video_url'       => 'sometimes|nullable',
        ]);
        if($validator->fails())
        {
            return res_failed($validator->errors());
        }
        $addcat = Blog::where('id',$id)->first();
        if($request->has('blog_image'))
        {
            
            if(Storage::disk('public')->exists($addcat->blog_image))
            {
                Storage::disk('public')->delete($addcat->blog_image);
            }
            $name = time().'_'.$request->blog_image->getClientOriginalName();
            Storage::disk('public')->put('BlogImages/'.$name,file_get_contents($request->blog_image),'public');
            $addcat->blog_image  = 'BlogImages/'.$name;
        }
        if ($request->video_url!=null && strpos($request->video_url, 'watch?v=') !== false) {
            $request->video_url = str_replace('watch?v=','embed/',$request->video_url);
        }
        $addcat->author  = auth()->user()->id;
        $addcat->type  = 'admin';
        $addcat->category_id   = $request->category_id ;
        $addcat->blog_title  = $request->blog_title;
        $addcat->blog_description  = $request->description;
        $addcat->video_url  = $request->video_url;
        $addcat->active  = $request->status =='on' ? 1 : 0;
        $addcat->save();

        return res_success('Success!',['data'=> $addcat]);
    }

    
    public function destroy($id)
    {
        $cat=Blog::find($id);
        // dd($cat);
        if($cat->active ==1)
        {
            $cat->active = 0;
        }
        elseif($cat->active ==0)
        {
            $cat->active = 1;
        }
        $cat->update();

        return res_success('Success!',['data'=> $cat]);
       
    }
}
