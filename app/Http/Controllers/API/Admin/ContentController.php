<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\User;
use App\Models\Content;
use App\Models\AppContent;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{

    public function app_index()
    {
        $data['privacy_policy'] = AppContent::where('key','privacy_policy')->get();
        $data['term_condition'] = AppContent::where('key','term_condition')->get();
        $data['disclaimer'] = AppContent::where('key','disclaimer')->get();

        return res_success('Success!',['data'=> $data]);
    }
    public function app_content_edit($id)
    {
        $data['keydata'] = $id;
        $data['privacy_policy'] = AppContent::where('key',$id)->get();
        $data['term_condition'] = AppContent::where('key',$id)->get();
        $data['disclaimer'] = AppContent::where('key',$id)->get();

        return res_success('Success!',['data'=> $data]);
    }
    public function app_update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'=>'required|array',
            'id.*'=>'required',
            'key' => 'required|array',
            'key.*' => 'required|',
            'heading' => 'required|array',
            'heading.*' => 'required',
            'content' => 'required|array',
            'content.*' => 'required',
        ]);

        if($validator->fails())
        {
        	return res_failed($validator->errors());
        }    
        if(sizeof($request["heading"]) == sizeof($request["content"]))
        {    
            for($i=0;$i<sizeof($request["id"]);$i++)
            {
                AppContent::where('id',$request["id"]["$i"])->update(['heading' =>$request["heading"]["$i"], 'content' =>$request["content"]["$i"]]);
            }
            return res_success('Success!',['data'=> '']);
        }
        else 
        {
            return res_failed('App Content Not Updated');
        }
    }
    public function app_store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'key' => 'required',
            'heading' => 'required|array',
            'heading.*' => 'required',
            'content' => 'required|array',
            'content.*' => 'required',
        ]);

        if($validator->fails())
        {
        	return res_failed($validator->errors());
        }
        if(sizeof($request["heading"]) == sizeof($request["content"]))
        {
            for($i=0;$i<sizeof($request["heading"]);$i++)
            {
                $app_content =new AppContent;
                $app_content->key=$request->key;
                $app_content->heading=$request["heading"]["$i"];
                $app_content->content=$request["content"]["$i"];
                $app_content->save();
            }
            return res_success('Success!',['data'=> '']);
        }
        else 
        {
            return res_failed('App Content Not Added');
        }

    }
    public function addappcontent()
    {
        $data = [];
        return res_success('Success!',['data'=> $data]);
    }
    public function appcontentdelete($id)
    {
        AppContent::where('id',$id)->delete();
        return res_success('Success!',['data'=> '']);
    }
}
