<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:setting-list|setting-edit', ['only' => ['index']]);
        $this->middleware('permission:setting-edit', ['only' => ['updateappversion','updatecompanymobile','updatecompanyaddress','updatecompanyemail','updateappname','updatecopyright','updatelogo','updateadminemail']]);
    }

    public function index(Request $request)
    {
        $data['name']=Setting::where('key','name')->first();
        $data['logo']=Setting::where('key','logo')->first();
        $data['copyright']=Setting::where('key','copyright')->first();
        $data['admin_data']=Admin::where('id','1')->first();
        
        $data['app_address']=Setting::where('key','app_address')->first();
        $data['app_email']=Setting::where('key','app_email')->first();
        $data['app_mobile']=Setting::where('key','app_mobile')->first();
        $data['app_version']=Setting::where('key','app_version')->first();
        return res_success('Success!',['data'=> $data]);
    }

    public function profile_index(Request $request)
    {
        $data['admin_data']=Admin::where('id',auth()->user()->id)->first();
       
        return res_success('Success!',['data'=> $data]);
    }

    public function updateappname(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'=>'required|exists:settings',
            'key' => 'required|string|max:255',
            'appname' => 'required',
        ]);
        if($validator->fails())
        {
            return res_failed($validator->errors());
        }          
        
        Setting::where('id',$request->id)->update(['key' =>$request->key, 'value' =>$request->appname]);

        return res_success('Success!',['data'=> '']);
    }
    public function updatecopyright(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'=>'required|exists:settings',
            'key' => 'required|string|max:255',
            'copyright' => 'required',
        ]);

        if($validator->fails())
        {
        	return res_failed($validator->errors());
        }          
        
        Setting::where('id',$request->id)->update(['key' =>$request->key, 'value' =>$request->copyright]);
        return res_success('Success!',['data'=> '']);
    }
    public function updatelogo(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'=>'required|exists:settings',
            'key' => 'required|string|max:255',
            'logo'=>'required|mimes:jpg,png,jpeg|max:800',
        ]);
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        }  
        $editlogo= Setting::where('id',$request->id)->first();
        if($request->has('logo')) 
        {
            $filePath = $editlogo->value;
            if($filePath != null)
            { 
               $filePath1 = storage_path('app/public/'. $filePath);
               if(is_file($filePath1))
               {
                  unlink($filePath1);
               } 
            } 
            $logofile = $request->file('logo');
            $logo_image = time().'_'.$logofile->getClientOriginalName();
            $upload_success1 = $request->file('logo')->storeAs('public/LOGO',$logo_image);    
            $uploaded_logo_image = 'LOGO/'.$logo_image; 
            $editlogo->value =  $uploaded_logo_image;
           
        }
        $editlogo->update();        
        
        return res_success('Success!',['data'=> '']);
    }
    public function updateadminemail(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'=>'required|exists:settings',
            'email' => 'required|email',
        ]);

        if($validator->fails())
        {
        	return res_failed($validator->errors());
        }          
        
        Admin::where('id',$request->id)->update(['email' =>$request->email]);
        return res_success('Success!',['data'=> '']);
    }
    public function updateadminpassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'=>'required|exists:settings',
            'old_password' => 'required|min:6|max:16',
            'password' => 'required|confirmed|min:6|max:16',
        ]);

        if($validator->fails())
        {
        	return res_failed($validator->errors());
        } 
        $errors=[];
        $admin = Admin::where('id',$request->id)->first();         
        if(!Hash::check($request->old_password ,$admin->password) )
        {
            $errors['old_password'] = ['The Old Password does not match.'];
            throw ValidationException::withMessages($errors);
            return res_failed($errors);
        }
        else
        {
            Admin::where('id',$request->id)->update(['password' =>Hash::make($request->password)]);
        }
        return res_success('Success!',['data'=> '']);
    }
    public function updatecompanyemail(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'=>'required|exists:settings',
            'key' => 'required|string|max:255',
            'app_email' => 'required|email',
        ]);

        if($validator->fails())
        {
        	return res_failed($validator->errors());
        }          
        
        Setting::where('id',$request->id)->update(['key' =>$request->key, 'value' =>$request->app_email]);
        return res_success('Success!',['data'=> '']);
    }
    public function updatecompanyaddress(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'=>'required|exists:settings',
            'key' => 'required|string|max:255',
            'app_address' => 'required',
        ]);

        if($validator->fails())
        {
        	return res_failed($validator->errors());
        }          
        
        Setting::where('id',$request->id)->update(['key' =>$request->key, 'value' =>$request->app_address]);
        return res_success('Success!',['data'=> '']);
    }
    public function updatecompanymobile(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'=>'required|exists:settings',
            'key' => 'required|string|max:255',
            'app_mobile' => 'required|min:7|numeric',
        ]);

        if($validator->fails())
        {
        	return res_failed($validator->errors());
        }          
        
        Setting::where('id',$request->id)->update(['key' =>$request->key, 'value' =>$request->app_mobile]);
        return res_success('Success!',['data'=> '']);
    }

    public function updateappversion(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'=>'required|exists:settings',
            'key' => 'required|string|max:255',
            'app_version' => 'required|string',
        ]);

        if($validator->fails())
        {
        	return res_failed($validator->errors());
        }          
        
        Setting::where('id',$request->id)->update(['key' =>$request->key, 'value' =>$request->app_version]);
        return res_success('Success!',['data'=> '']);
    }

}
