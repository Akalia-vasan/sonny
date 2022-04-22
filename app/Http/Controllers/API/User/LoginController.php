<?php

namespace App\Http\Controllers\API\User;


use Exception;
use App\Models\User;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\UserOtp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    
    public function get_profile(Request $request)
    {
        $user=User::where('id',auth()->user()->id)->first();
        if($user)
        {
            $userdata['userdata']['id']=$user->id;
            $userdata['userdata']['name']=$user->name?$user->name:'';
            $userdata['userdata']['email']=$user->email?$user->email:'';
            $userdata['userdata']['mobile']=$user->mobile?$user->mobile:'';
            $userdata['userdata']['profile_image']=$user->profile_image;
            $userdata['userdata']['dob']=$user->dob;	
            $userdata['userdata']['gender']=$user->gender;	
            $userdata['userdata']['blood_group']=$user->blood_group;	
            $userdata['userdata']['address']=$user->address;	
            $userdata['userdata']['bank_name']=$user->bank_name;	
            $userdata['userdata']['ifsc_code']=$user->ifsc_code;	
            $userdata['userdata']['account']=$user->account;	
            $userdata['userdata']['account_name']=$user->account_name;		
        }
        if($userdata)
        {
            return res_success('Success!',  $userdata);   
        }
        else 
        {
            return res_failed('Data Not Found!'); 
        }      
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'  =>  'required|string|max:255',
            'username' => 'required',
            'otp'       =>  'required|digits:4',
        ]);
     
        if($validator->fails())
        {  
            return  res_failed($validator->errors()->first());    
        }

        if(preg_match('/^\d{10}$/', $request->username))
        {  
            if(User::where('mobile',$request->username)->count()==0)
            {
                $userOtp = UserOtp::where('mobile', $request->username)->first();
                $type='mobile';
            }
            else
            {       
                $userOtp = UserOtp::where('mobile',$request->username)->delete();
                throw ValidationException::withMessages([
                    'username' => ['Mobile number Already registered Please Login.'],
                ]);
                
            }
        }
        elseif(filter_var($request->username, FILTER_VALIDATE_EMAIL))
        {
            if(User::where('email', $request->username)->count()==0)
            {
                $userOtp = UserOtp::where('email', $request->username)->first();
                $type='email';
            }else{
                $userOtp = UserOtp::where('email', $request->username)->delete();
                throw ValidationException::withMessages([
                    'username' => ['Email Already registered Please Login.'],
                ]); 
            }
        }
        else
        {
            throw ValidationException::withMessages([
                'username' => ['Username must a valid email or mobile number.'],
            ]);
            $type='';
        }
        

        if($userOtp)
        {
            $startTime = $userOtp['created_at'];

            $to_time = strtotime($startTime);
            $from_time = strtotime(date('Y-m-d H:i:s'));
            $time = round(($from_time - $to_time) / 60);

            if($time>10)
            {
                return res_failed('The given data was invalid.',['errors'=>['otp'=>'Invalid Otp']]);
            }
            else
            {
                if($userOtp->attempt < 5)
                {
                    $userOtp->attempt = $userOtp->attempt + 1;
                    $userOtp->save();

                    if($userOtp->otp == $request->otp)
                    {
                        $userOtp->delete();
                    }
                    else
                    {
                        return res_failed('The given data was invalid.',['errors'=>['otp'=>'Invalid Otp']]);  
                    }
                }
                else
                {
                    return res_failed('The given data was invalid.',['errors'=>['otp'=>'Too many attempts please resend it!']]);
                }
            }
        }
        else
        {
            return res_failed('The given data was invalid.',['errors'=>['otp'=>'Please send otp first!']]);
        }

        $data['name'] = $request->name;
        if($type=='email'){
            $data['email'] = $request->username;
        }else{
            $data['mobile'] = $request->username;
        }
        $data['password'] = bcrypt('password');
        $data['send_password'] = 'password';
        $userSave = User::create($data);
        $userData = User::find($userSave->id);
        $token = $this->_token($request->username, 'password');
        if(isset($token['access_token']))
        {
            $user = [];
            $user['name'] =  $userData['name'] ? $userData['name']:'';
            $user['email'] =  $userData['email'] ? $userData['email']:'';
            $user['mobile'] =  $userData['mobile'] ? $userData['mobile']:'';
            $user['active'] =  $userData['active'] ? $userData['active']:0;
            return res_success('Success!', [
                'user'          =>  $user,
                'token_type'    =>  $token['token_type'],
                'expires_in'    =>  $token['expires_in'],
                'access_token'  =>  $token['access_token'],
                'refresh_token' =>  $token['refresh_token'],
            ],201);
        }
        return res(500, 'Please generate clients first!');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username'  =>  'required|string|max:255',
            'otp'       =>  'required|integer|digits:4'
        ]);
        if($validator->fails())
        {   
            return res_failed($validator->errors()->first());     
        }
        $data['username'] = $request->username;
        $data['otp']      = $request->otp;

        if(preg_match('/^\d{10}$/', $data['username']))
        {
            if(User::where('mobile', $data['username'])->count())
            {
                $userOtp = UserOtp::where('mobile', $data['username'])->first();
                $user = User::where('mobile', $data['username'])->first();
            }
            else{
                throw ValidationException::withMessages([
                    'username' => ['Mobile number not registered.'],
                ]);
            }
        }
        elseif(filter_var($data['username'], FILTER_VALIDATE_EMAIL))
        {
            if(User::where('email', $data['username'])->count())
            {
                $userOtp = UserOtp::where('email', $data['username'])->first();
                $user = User::where('email', $data['username'])->first();
            }
            else{
                throw ValidationException::withMessages([
                    'username' => ['Email not registered.'],
                ]);
            }
        }
        else
        {
            throw ValidationException::withMessages([
                'username' => ['Username must a valid email or mobile number.'],
            ]);
        }

        if($userOtp)
        {
            $startTime = $userOtp['created_at'];

            $to_time = strtotime($startTime);
            $from_time = strtotime(date('Y-m-d H:i:s'));
            $time = round(($from_time - $to_time) / 60);
            if($time>10)
            {
                throw ValidationException::withMessages([
                    'otp' => ['Otp Time Expired!.'],
                ]);
            }
            else
            {
                if($userOtp->attempt < 5)
                {
                    $userOtp->attempt = $userOtp->attempt + 1;
                    $userOtp->save();
                    if($userOtp->otp == $request->otp)
                    {
                        $userOtp->delete();
                        $token = $this->_token($request->username, 'password');
                        if($token){
                            $userData = [];
                            $userData['name'] =  $user['name'] ? $user['name']:'';
                            $userData['email'] =  $user['email'] ? $user['email']:'';
                            $userData['mobile'] =  $user['mobile'] ? $user['mobile']:'';
                            $userData['active'] =  $user['active'] ? $user['active']:0;                          
                            return res_success('Success!', [
                                'user'          =>  $userData,
                                'token_type'    =>  $token['token_type'],
                                'expires_in'    =>  $token['expires_in'],
                                'access_token'  =>  $token['access_token'],
                                'refresh_token' =>  $token['refresh_token'],
                            ]);
                        }
                    }else{
                        throw ValidationException::withMessages([
                            'otp' => ['Invalid otp!.'],
                        ]);  
                    }
                }
            }
            return res_failed('Too many attempts please resend it!');
        }else{
            throw ValidationException::withMessages([
                'otp' => ['Invalid or expired otp please resend!.'],
            ]);
        }
    }

    public function socialLogin(Request $request)
    {
        $request->validate([
            'email'    =>  'required|email',
            'name'  =>  'required|string|max:255',
            'image'  =>  'sometimes|string',
        ]);
        $user = User::where('email', $request->email)->first();
        if(empty($user)){
            $password = 'password';       
            $USER = new User();
            $USER->name = $request->name;
            $USER->email = $request->email;
            $USER->profile_image = $request->image;
            $USER->email_verified_at = now();
            $USER->password = bcrypt($password);
            $USER->send_password = $password;
            $USER->save();
            $user = User::where('email',$request->email)->first();    
        }
        if($user->email_verified_at==null){
            $user->email_verified_at==now();
            $user->save();
        }
        if($user->profile_image==null){ 
            $user->profile_image = $request->image;
            $user->save();
        }

        $token = $this->_token($user->email,$user->send_password);
        if(isset($token['access_token']))
        {
            $userData = [];
            $userData['name'] =  $user->name ? $user->name:'';
            $userData['profile_image'] =  $user->profile_image ? $user->profile_image:'';
            $userData['email'] =  $user->email ? $user->email:'';
            $userData['mobile'] =  $user->mobile ? $user->mobile:'';
            $userData['active'] =  $user->active ? $user->active:0; 
            return res_success('Success!', [
                'user'          =>  $userData,
                'token_type'    =>  $token['token_type'],
                'expires_in'    =>  $token['expires_in'],
                'access_token'  =>  $token['access_token'],
                'refresh_token' =>  $token['refresh_token'],
            ]);
        }
        return res(500, 'Server Error!');
    }

    public function update_profile_image(Request $request)
    {
            $validator =  Validator::make($request->all(),[
                'profile_image'=>'required|mimes:jpg,png,jpeg|max:3072',    
                ]
            );

            if($validator->fails())
            {
        	    return res_failed($validator->errors());
            }
            
            $editprofile= User::where('id',auth()->user()->id)->first();
            if($editprofile)
            {
                if($request->has('profile_image')) 
                {
                    $filePath = @$editprofile->getAttributes()['profile_image'];
                    
                    if($filePath != null)
                    {
                        $filePath1 = storage_path('app/public/'.$editprofile->getAttributes()['profile_image']);
                        if(file_exists($filePath1)){
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
                        $userdata['userdata']['id']=$editprofile->id;
                        $userdata['userdata']['name']=$editprofile->name?$editprofile->name:'';
                        $userdata['userdata']['email']=$editprofile->email?$editprofile->email:'';
                        $userdata['userdata']['mobile']=$editprofile->mobile?$editprofile->mobile:'';
                        $userdata['userdata']['profile_image']=$editprofile->profile_image;
                        $userdata['userdata']['dob']=$editprofile->dob;	
                        $userdata['userdata']['gender']=$editprofile->gender;	
                        $userdata['userdata']['blood_group']=$editprofile->blood_group;	
                        $userdata['userdata']['address']=$editprofile->address;	
                        $userdata['userdata']['bank_name']=$editprofile->bank_name;	
                        $userdata['userdata']['ifsc_code']=$editprofile->ifsc_code;	
                        $userdata['userdata']['account']=$editprofile->account;	
                        $userdata['userdata']['account_name']=$editprofile->account_name;		
                        return res_success('Success!',  ['userdata'=>$userdata]);   
                    }
                }
            }
    
    }

    public function update_profile(Request $request)
    {
        $id = auth()->user()->id;
        $data = $request->validate([
            'name'  =>  'sometimes|nullable|string',
            'mobile'  =>  "sometimes|numeric|min:10|unique:users,mobile,$id",
            'email'  =>  "sometimes|email|unique:users,email,$id",
            'dob'  =>  'sometimes|date',
            'gender' =>  'sometimes|in:Male,Female',
            'blood_group' =>  'sometimes|in:A+,A+,B-,B+,O-,O+,AB-,AB+',
            'address'  =>  'sometimes|string',
            'bank_name'  =>  'sometimes|string',
            'ifsc_code'  =>  'sometimes|string',
            'account'  =>  'sometimes|numeric',
            'account_name'  =>  'sometimes|string',
        ]);
            
        $editprofile= User::where('email',auth()->user()->email)->first();
        if($editprofile)
        {
            $editprofile->name =  $request->name!=null?$request->name:$editprofile->name;
            $editprofile->mobile =  $request->mobile!=null?$request->mobile:$editprofile->mobile;
            $editprofile->dob =  $request->dob!=null?$request->dob:$editprofile->dob;
            $editprofile->gender =  $request->gender!=null?$request->gender:$editprofile->gender;
            $editprofile->blood_group =  $request->blood_group!=null?$request->blood_group:$editprofile->blood_group;
            $editprofile->address =  $request->address!=null?$request->address:$editprofile->address;
            $editprofile->bank_name =  $request->bank_name!=null?$request->bank_name:$editprofile->bank_name;
            $editprofile->ifsc_code =  $request->ifsc_code!=null?$request->ifsc_code:$editprofile->ifsc_code;
            $editprofile->account =  $request->account!=null?$request->account:$editprofile->account;
            $editprofile->account_name =  $request->account_name!=null?$request->account_name:$editprofile->account_name;
            if($editprofile->update()){
                $userdata['userdata']['id']=$editprofile->id;
                $userdata['userdata']['name']=$editprofile->name?$editprofile->name:'';
                $userdata['userdata']['email']=$editprofile->email?$editprofile->email:'';
                $userdata['userdata']['mobile']=$editprofile->mobile?$editprofile->mobile:'';
                $userdata['userdata']['profile_image']=$editprofile->profile_image;	
                $userdata['userdata']['dob']=$editprofile->dob;	
                $userdata['userdata']['gender']=$editprofile->gender;	
                $userdata['userdata']['blood_group']=$editprofile->blood_group;	
                $userdata['userdata']['address']=$editprofile->address;	
                $userdata['userdata']['bank_name']=$editprofile->bank_name;	
                $userdata['userdata']['ifsc_code']=$editprofile->ifsc_code;	
                $userdata['userdata']['account']=$editprofile->account;	
                $userdata['userdata']['account_name']=$editprofile->account_name;	
                return res_success('Success!',  ['userdata'=>$userdata]); 
            } 
        }
        return res_failed('Data Not Found!');
    }

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username'    =>  'required',
        ]);
        if($validator->fails())
        {   
            return res_failed($validator->errors()->first());     
        }
        if(preg_match('/^\d{10}$/', $request->username))
        {
            sendOtp($request->username);
            return res_success('Otp sent to your mobile number!');
        }
        elseif(filter_var($request->username, FILTER_VALIDATE_EMAIL))
        {
            EmailSendOtp($request->username);           
            return res_success('Otp sent to your email!');
        }
        else
        {
            throw ValidationException::withMessages([
                'username' => ['Username must a valid email or mobile number.'],
            ]);
        }

    }

    public function refreshToken(Request $request)
    {
        $request->validate([
            'refresh_token' =>  'required|string',
        ]);

        $token = $this->_tokenRefresh($request->refresh_token);

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
            $response = Http::asForm()->post(url('oauth/token'), [
                'grant_type' => 'password',
                // 'provider' => 'users',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $username,
                'password' => $password,
                // 'scope' => '',
            ]);

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
                // 'provider' => 'users',
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
        ->where('provider', 'users')
        ->where('password_client', 1)
        ->first();
    }

}