<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function getAllBanner(Request $request)
    {
        $banners = Banner::where('active',1)->limit(5)->orderBy('created_at','desc')->get();
        if(count($banners)==0){
            return res_failed('No Data Found!');
        }
        $allbanner=[];
        foreach($banners as $banner){
            $allbanner[]=[
                'id'=> $banner->id,
                'title'=> $banner->title,
                'image'=> url('storage/'.$banner->image),
            ];  
        }
        return res_success('Success!',['banners'=>$allbanner]);
    }
}
