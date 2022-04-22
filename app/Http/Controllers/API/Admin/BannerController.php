<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{

    public function index()
    {
        $list = Banner::get();

        return res_success('Success!', ['banners'=> $list]);
    }

    public function create()
    {
        $list = Banner::all();

        return res_success('Success!', ['banners'=> $list]);
    }

    public function edit($id)
    {
        $banner = Banner::where('id',$id)->first();

        return res_success('Success!', ['banner'=> $banner]);
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'title' => 'required|unique:banners',
            'image' => 'required|image',
        ]);
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        } 
            
        $banner = new Banner();
        $banner->title = $request->title;
        if($request->has('image'))
        {
            $backupLoc='public/banner/';
            if(!is_dir($backupLoc)) {
                Storage::makeDirectory($backupLoc, 0755, true, true);
            }
            $name = time().'_'.$request->image->getClientOriginalName();
            Storage::disk('public')->put('banner/'.$name,file_get_contents($request->image),'public');
            $banner->image  = 'banner/'.$name;
        }
        $banner->active = $request->status == 'on' ? 1 : 0;
        $banner->save();

        return res_success('Success!',['banner' => $banner]);
    }
    public function update(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'title' => 'required|unique:banners,title,'.$id,
            'image' => 'sometimes|nullable|image',
        ]);
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        }

        $banner = Banner::where('id',$id)->first();
        $banner->title = $request->title;
        if($request->has('image'))
        {
            
            if(Storage::disk('public')->exists($banner->image))
            {
                Storage::disk('public')->delete($banner->image);
            }
            $name = time().'_'.$request->image->getClientOriginalName();
            Storage::disk('public')->put('banner/'.$name,file_get_contents($request->image),'public');
            $banner->image  = 'banner/'.$name;
        }
        $banner->active = $request->status == 'on' ? 1 : 0;
        $banner->save();

        return res_success('Success!',['banner' => $banner]);
    }
    public function destroy($id)
    {
        $banner = Banner::where('id',$id)->first();
        if(Storage::disk('public')->exists($banner->image))
        {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();

        return res_success('Success!',['banner' => '']);
    }


}
