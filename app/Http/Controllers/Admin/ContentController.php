<?php

namespace App\Http\Controllers\Admin;

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
         $data['privacy_policy']=AppContent::where('key','privacy_policy')->get();
         $data['term_condition']=AppContent::where('key','term_condition')->get();
         $data['disclaimer']=AppContent::where('key','disclaimer')->get();
        return view('admin.content.app_content_list',$data);
    }
    public function app_content_edit($id)
    {
        $data['keydata'] = $id;
        $data['privacy_policy']=AppContent::where('key',$id)->get();
        $data['term_condition']=AppContent::where('key',$id)->get();
        $data['disclaimer']=AppContent::where('key',$id)->get();
        return view('admin.content.app_content_edit',$data);
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
        	return redirect()->back()->withErrors($validator->errors());
        }    
        if(sizeof($request["heading"]) == sizeof($request["content"]))
        {    
            for($i=0;$i<sizeof($request["id"]);$i++)
            {
                AppContent::where('id',$request["id"]["$i"])->update(['heading' =>$request["heading"]["$i"], 'content' =>$request["content"]["$i"]]);
            }
            Session::flash('success', 'App Content Update');
            return redirect()->route('admin.appcontent');
        }
        else 
        {
            Session::flash('failed', 'App Content Not Updated');
            return redirect()->route('admin.appcontent');
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
        	return redirect()->back()->withErrors($validator->errors())->withInput();
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
            Session::flash('success', 'App Content Added');
            return redirect()->route('admin.appcontent');
        }
        else 
        {
            Session::flash('failed', 'App Content Not Added');
            return redirect()->route('admin.appcontent');
        }

    }
    public function addappcontent()
    {
        $data=[];
        return view('admin.content.add_app_content',$data);
    }
    public function appcontentdelete($id)
    {
        AppContent::where('id',$id)->delete();
        return redirect()->back();
    }
}
