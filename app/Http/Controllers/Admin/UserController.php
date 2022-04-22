<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:patient-list', ['only' => ['patientindex']]);
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','storeUser','get','showUser']]);
        $this->middleware('permission:user-create', ['only' => ['addUser','storeUser']]);
        $this->middleware('permission:user-edit', ['only' => ['editUser','updateUser']]);
        $this->middleware('permission:user-delete', ['only' => ['userdelete']]);
    }

    public function patientindex()
    {
        $data['alluser']=User::get();
        return view('admin.patient.index',$data);
    }

    public function index()
    {
        $data['alluser']=User::get();
        return view('admin.user.index',$data);
    }
    public function ShowFarm()
    {
        return view('admin.auth.loginrefresh');
    }
    public function validate_time(Request $request)
    {
      $user = Auth::guard('admin')->user();
        
      if($user)
      {
        
          if (Hash::check($request->password, $user->password) ) 
          {
              $request->session()->put('login_time', time());
              return  redirect( route('admin.home') );
          }
          else
          {
            throw ValidationException::withMessages([
                'password' => 'Password is Wrong.',
            ]);
            return  redirect(route('admin.password')); 
          }

      }
      else
      {
        $request->session()->put('login_time', time());
        return  redirect( route('admin.login') );
      }
    }

    public function get(Request $request)
    {
        $query = User::select('*');
        
        return datatables()->of($query)
        ->addColumn('action', function ($row) {
            $html = "<a class='btn btn-sm bg-primary-light' 
                href='". route('admin.user.show', $row->id) ."'>
                <i class=' fa fa-eye'></i></a>
                <a class='btn btn-sm bg-success-light' 
                href='". route('admin.user.edit', $row->id) ."'>
                <i class=' fa fa-pencil'></i></a>
                <a class='demotest1 btn btn-sm bg-danger-light'
                    href='". route('admin.user.delete', $row->id) ."'>
                    <i class=' fa fa-trash'></i></a> ";
                     
            return $html;
        })
        ->toJson();
    }

    public function addUser()
    {
        $data=[];
        return view('admin.user.add',$data);
    }

    public function storeUser(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'         => 'required|string',
            'email'        => 'required|email|unique:users',
            'mobile'     => 'sometimes|nullable|unique:users|numeric',
            'password'     => 'required|min:6',
        ]);
        if($validator->fails())
        {
        	return redirect()->back()->withErrors($validator->errors())->withInput();
        }  
        if($request->status=='on')
        {
            $status= 1;
        }
        else 
        {
            $status=0;
        }
        $adduser = new User;
        $adduser->name = $request->name;
        $adduser->email = $request->email;
        $adduser->mobile = $request->mobile;
        $adduser->password = Hash::make($request->password);
        $adduser->mobile_verified_at = Carbon::now();
        $adduser->email_verified_at = Carbon::now();
        $adduser->active = $status;
        $adduser->save();

        return redirect()->route('admin.user.index')->with('success','User Added!');
    }

    public function showUser($id)
    {
        $data['userdata'] = User::where('id',$id)->first();
        return view('admin.user.show',$data);
    }

    public function editUser($id)
    {
        $data['user'] = User::where('id',$id)->first();
        return view('admin.user.edit',$data);
    }

    public function updateUser(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'id'           =>'required|integer|exists:users',
            'name'         => 'required|string',
            'email'        => "required|email|unique:users,email,$id",
            'mobile'       => "sometimes|nullable|numeric|unique:users,mobile,$id",
            'password'     => 'sometimes|nullable|min:6',
        ]);
        if($validator->fails())
        {
        	return redirect()->back()->withErrors($validator->errors());
        }  
        if($request->status=='on')
        {
            $status= 1;
        }
        else 
        {
            $status=0;
        }

        $edituser = User::where('id',$request->id)->first();
        $edituser->name = $request->name;
        $edituser->email = $request->email;
        $edituser->mobile = $request->mobile;
        if($request->password)
        {
            $edituser->password = Hash::make($request->password);
        }
        $edituser->mobile_verified_at = Carbon::now();
        $edituser->email_verified_at = Carbon::now();
        $edituser->active = $status;
        $edituser->update();
    
        return redirect()->route('admin.user.index')->with('success','User Update!');
    }

    public function userdelete(Request $request,$id)
    {
            User::where('id',$id)->delete();
            return redirect()->route('admin.user.index')->with('success','User Deleted!');
    }

}
