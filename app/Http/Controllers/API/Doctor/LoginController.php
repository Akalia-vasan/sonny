<?php

namespace App\Http\Controllers\API\Doctor;


use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function get_profile(Request $request)
    {
        $doctor = Doctor::where('id',auth()->user()->id)->first();
        if($doctor)
        {
            $doctordata['doctordata']['id']=$doctor->id;
            $doctordata['doctordata']['type']=$doctor->type;
            $doctordata['doctordata']['owner']=$doctor->entity_id?$doctor->getEntity->name:'Self';
            $doctordata['doctordata']['name']=$doctor->name?$doctor->name:'';
            $doctordata['doctordata']['email']=$doctor->email?$doctor->email:'';
            $doctordata['doctordata']['mobile']=$doctor->mobile?$doctor->mobile:'';
            $doctordata['doctordata']['profile_image']=$doctor->profile_image;
            $doctordata['doctordata']['dob']=$doctor->dob;	
            $doctordata['doctordata']['gender']=$doctor->gender;	
            $doctordata['doctordata']['blood_group']=$doctor->blood_group;	
            $doctordata['doctordata']['address']=$doctor->address;	
            $doctordata['doctordata']['bank_name']=$doctor->bank_name;	
            $doctordata['doctordata']['ifsc_code']=$doctor->ifsc_code;	
            $doctordata['doctordata']['account']=$doctor->account;	
            $doctordata['doctordata']['account_name']=$doctor->account_name;		
        }
        if($doctordata)
        {
            return res_success('Success!',  $doctordata);   
        }
        else 
        {
            return res_failed('Data Not Found!'); 
        }      
    }

    public function update_profile_image(Request $request)
    {
            $data = $request->validate([
                'profile_image'=>'required|mimes:jpg,png,jpeg|max:3072',
            ]);
            
            $editprofile= Doctor::where('id',auth()->user()->id)->first();
            if($editprofile)
            {
                if($request->has('profile_image')) 
                {
                    $filePath = @$editprofile->getAttributes()['profile_image'];
                    
                    if($filePath != null)
                    {
                        $filePath1 = storage_path('app/public/'.$editprofile->getAttributes()['profile_image']);
                        if(File::exists(public_path($filePath1))){
                            unlink($filePath1);
                        } 
                    } 
                    $backupLoc='public/ProfileImage/';
                    if(!is_dir($backupLoc)) {
                        Storage::makeDirectory($backupLoc, 0755, true, true);
                    }
                    $profilefile = $request->file('profile_image');
                    $profile_image = time().'_'.$profilefile->getClientOriginalName();
                    $upload_success1 = $request->file('profile_image')->storeAs('public/ProfileImage',$profile_image);    
                    $uploaded_profile_image = 'ProfileImage/'.$profile_image; 
                    $editprofile->profile_image =  $uploaded_profile_image;
                        
                    if($editprofile->update())
                    {
                        $doctordata['id']=$editprofile->id;
                        $doctordata['type']=$editprofile->type;
                        $doctordata['owner']=$editprofile->entity_id?$editprofile->getEntity->name:'Self';
                        $doctordata['name']=$editprofile->name?$editprofile->name:'';
                        $doctordata['email']=$editprofile->email?$editprofile->email:'';
                        $doctordata['mobile']=$editprofile->mobile?$editprofile->mobile:'';
                        $doctordata['profile_image']=$editprofile->profile_image;
                        $doctordata['dob']=$editprofile->dob;	
                        $doctordata['gender']=$editprofile->gender;	
                        $doctordata['blood_group']=$editprofile->blood_group;	
                        $doctordata['address']=$editprofile->address;	
                        $doctordata['bank_name']=$editprofile->bank_name;	
                        $doctordata['ifsc_code']=$editprofile->ifsc_code;	
                        $doctordata['account']=$editprofile->account;	
                        $doctordata['account_name']=$editprofile->account_name;	
                        return res_success('Success!',  $doctordata); 
                    }
                }
            }
            return res_failed('Data Not Found!');
    
    }
    
    public function update_profile(Request $request)
    {
            $data = $request->validate([
                'name'  =>  'sometimes|nullable|string',
                'description' => 'sometimes|nullable|string',
            ]);
             
                $editprofile= Doctor::where('id',auth()->user()->id)->first();
                if($editprofile)
                {
                    $editprofile->name =  $request->name!=null?$request->name:$editprofile->name;
                    $editprofile->description =  $request->description!=null?$request->description:$editprofile->description;
                    $editprofile->update();
                    $doctordata['id']=$editprofile->id;
                    $doctordata['type']=$editprofile->type;
                    $doctordata['owner']=$editprofile->entity_id?$editprofile->getEntity->name:'Self';
                    $doctordata['name']=$editprofile->name?$editprofile->name:'';
                    $doctordata['email']=$editprofile->email?$editprofile->email:'';
                    $doctordata['mobile']=$editprofile->mobile?$editprofile->mobile:'';
                    $doctordata['profile_image']=$editprofile->profile_image;
                    $doctordata['dob']=$editprofile->dob;	
                    $doctordata['gender']=$editprofile->gender;	
                    $doctordata['blood_group']=$editprofile->blood_group;	
                    $doctordata['address']=$editprofile->address;	
                    $doctordata['bank_name']=$editprofile->bank_name;	
                    $doctordata['ifsc_code']=$editprofile->ifsc_code;	
                    $doctordata['account']=$editprofile->account;	
                    $doctordata['account_name']=$editprofile->account_name;	
                    return res_success('Success!',  $doctordata); 
                }
            return res_failed('Data Not Found!');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    =>  'required|email:rfc|exists:doctors',
            'password'  =>  'required|string|max:255',
        ]);

        $doctor = Doctor::where('email', $request->email)
        ->first();

        if($doctor)
        {
            if(Hash::check($request->password, $doctor->password))
            {
              $token = $this->_token($doctor->email, $request->password);
                if(isset($token['access_token']))
                {
                    $doctordata['id']=$doctor->id;
                    $doctordata['type']=$doctor->type;
                    $doctordata['owner']=$doctor->entity_id?$doctor->getEntity->name:'Self';
                    $doctordata['name']=$doctor->name?$doctor->name:'';
                    $doctordata['email']=$doctor->email?$doctor->email:'';
                    $doctordata['mobile']=$doctor->mobile?$doctor->mobile:'';
                    $doctordata['profile_image']=$doctor->profile_image;
                    $doctordata['dob']=$doctor->dob;	
                    $doctordata['gender']=$doctor->gender;	
                    $doctordata['blood_group']=$doctor->blood_group;	
                    $doctordata['address']=$doctor->address;	
                    $doctordata['bank_name']=$doctor->bank_name;	
                    $doctordata['ifsc_code']=$doctor->ifsc_code;	
                    $doctordata['account']=$doctor->account;	
                    $doctordata['account_name']=$doctor->account_name;		
                    return res_success('Success!', [
                        'doctor'          =>  $doctordata,
                        'token_type'    =>  $token['token_type'],
                        'expires_in'    =>  $token['expires_in'],
                        'access_token'  =>  $token['access_token'],
                        'refresh_token' =>  $token['refresh_token'],
                    ]);
                }
                return res(500, 'Server Error!');
            }
            return res_failed('Invalid password!');
        }
        return res_failed('Invalid user!');
    }

    public function refreshToken(Request $request)
    {
       $request->validate([
           'refresh_token' =>  'required|string',
       ]);

       $token = $this->_tokenRefresh($request->refresh_token);
       //    dd($token);
       if(isset($token['access_token']))
       {
           return res_success('Success!', [
               'token_type'    =>  $token['token_type'],
               'expires_in'    =>  $token['expires_in'],
               'access_token'  =>  $token['access_token'],
               'refresh_token' =>  $token['refresh_token'],
           ]);
       }
       elseif(count($token))
       {
           return res_failed($token['message']);
       }
       return res(500, 'Server Error!');
    }

    private function _token($username, $password)
    {
        if ($client = $this->_client())
        {
            // dd($client);
            $response = Http::asForm()->post(url('oauth/token'), [
                'grant_type' => 'password',
                'provider' => 'doctors',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $username,
                'password' => $password,
                // 'scope' => '',
            ]);
            
            // dd($response->json());
            return $response->json();
        }
        return [];
    }
    private function _tokenRefresh($refresh_token)
    {
        if ($client = $this->_client())
        {
            $response = Http::asForm()->post(url('oauth/token'), [
                'grant_type' => 'refresh_token',
                'provider' => 'doctors',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'refresh_token' => $refresh_token,
                // 'scope' => '',
            ]);
            return $response->json();
        }
        return [];
    }
    private function _client()
    {
        return DB::table('oauth_clients')
        ->where('provider', 'doctors')
        ->where('password_client', 1)
        ->first();
    }

}