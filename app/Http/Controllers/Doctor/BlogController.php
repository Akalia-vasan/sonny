<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        $data['breadcrumb']=   "My Blogs";
        $data['allblog']=Blog::where('author',Auth::user()->id)->where('type','doctor')->where('active',1)->paginate(9);
        return view('doctor.blog.index',$data);
    }
    public function create()
    {
        $data['breadcrumb']=   "Blog Add";
        $data['blogcat']=BlogCategory::all();
        return view('doctor.blog.add',$data);
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
            return redirect()->back()->withErrors($validator->errors())->withInput();
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
        $addcat->type  = 'doctor';
        $addcat->category_id   = $request->category_id ;
        $addcat->blog_title  = $request->blog_title;
        $addcat->blog_description  = $request->description;
        $addcat->blog_image  = 'BlogImages/'.$name;
        $addcat->video_url  = $request->video_url;
        $addcat->active  = 1;
        $addcat->save();

        return redirect()->route('doctor.blog.index')->with('success','Blog Added!');
    }
    public function show($id)
    {
        $data['breadcrumb']=   "Blog Details";
        $data['allblog']=Blog::where('id',$id)->first();
        $data['allblogcomment']=BlogComment::where('blog_id',$id)->get();
        $data['latestblog']=Blog::where('active',1)->latest()->limit(5)->get();
        $data['blogcategory'] = Blog::groupBy('category_id')->select('category_id', DB::raw('count(*) as total'))->get();
        return view('doctor.blog.blogdetail',$data);
    }

    public function edit($id)
    {
        $data['breadcrumb']=   "Blog Edit";
        $data['blogcat']=BlogCategory::get();
        $data['editblog']=Blog::where('id',$id)->first();
        return view('doctor.blog.edit',$data);
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
            return redirect()->back()->withErrors($validator->errors())->withInput();
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
        $addcat->type  = 'doctor';
        $addcat->category_id   = $request->category_id ;
        $addcat->blog_title  = $request->blog_title;
        $addcat->blog_description  = $request->description;
        $addcat->video_url  = $request->video_url;
        $addcat->active  = 1;
        $addcat->save();

        return redirect()->route('doctor.blog.index')->with('success','Blog Updated!');
    }
}
