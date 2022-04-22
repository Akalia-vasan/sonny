<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Admin;
use App\Models\Center;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SubAdminController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:subadmin-list|subadmin-create|subadmin-edit|subadmin-delete', ['only' => ['index','store']]);
         $this->middleware('permission:subadmin-create', ['only' => ['create','store']]);
         $this->middleware('permission:subadmin-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:subadmin-delete', ['only' => ['destroy']]);
    }


    public function index()
    {
        $data['subadmins']=Admin::where('is_super_admin',0)->get();
        // dd($data['subadmins']);
        // $data['subadmins']=Admin::where('is_super_admin',0)->get();
        return view('admin.subadmin.index',$data);
    }

    public function create()
    {
        $data['allrole'] = Role::where('name','!=','Admin')->get();
       
        return view('admin.subadmin.add',$data);
    }


    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'       => 'required|string',
            'email'      => ['required', 'max:255', 'email', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', "unique:admins,email"],
            'password'   => 'required|min:6',
            'image'       => 'required|image|mimes:jpg,png,jpeg',
            'role'       => 'required|not_in:0',    
        ]);
        if($validator->fails())
        {
            // dd($validator->errors());
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } 

        $subadmin = new Admin;
        $backupLoc='public/SubAdminImage/';
        if(!is_dir($backupLoc)) {
           Storage::makeDirectory($backupLoc, 0755, true, true);
        }
        if($request->file('image')){
            $file = $request->file('image');
            $image = time().'_'.$file->getClientOriginalName();
            $upload_success1 = $request->file('image')->storeAs('public/SubAdminImage',$image);    
            $uploaded_image = 'SubAdminImage/'.$image; 
            $subadmin->image          = $uploaded_image;
        }

        $subadmin->name          = $request->name;
        $subadmin->email         = $request->email;
        $subadmin->password      = Hash::make($request->password);
        $subadmin->send_password     = $request->password;
        $subadmin->type          = $request->role;
        $subadmin->is_super_admin  =  0 ;
        if($subadmin->save())
        {
            $subadmin->assignRole($request->role);
            $details = [
                'email' => $subadmin->email,
                'password'=> $subadmin->send_pass,
            ];
            try
            {
                Mail::to($subadmin->email)->send(new \App\Mail\InstructorCredential($details));
            } catch (Exception $e) {}
        }

        return redirect()->route('admin.subadmin.index')->with('success','Sub-Admin Added!');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $data['subadmins']=Admin::where('admins.id',$id)->first();
        // $data['center'] = Center::where('active','1')->get();
        $data['allrole'] = Role::where('name','!=','Admin')->get();
        return view('admin.subadmin.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validator=Validator::make($request->all(),[
            'email'      => ['required', 'max:255', 'email', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', "unique:admins,email,$id"],
            'name'       => 'required|string',
            'password'   => 'sometimes|nullable|min:6',
            'image'       => 'sometimes|image|mimes:jpg,png,jpeg',
            'role'       => 'required|not_in:0',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }  

        $status= $request->status=='on' ? 1 : 0 ;
        $subadmin = Admin::where('id',$id)->first();

        if($request->has('image')) 
        {
            //Image delete
            $filePath = $subadmin->image;
            if($filePath != null)
            { 
               $filePath1 = storage_path('app/public/'. $filePath);
               if(is_file($filePath1))
               {
                  unlink($filePath1);
               } 
            } 
            if($request->file('image')){
                $file = $request->file('image');
                $image = time().'_'.$file->getClientOriginalName();
                $upload_success1 = $request->file('image')->storeAs('public/SubAdminImage',$image);    
                $uploaded_image = 'SubAdminImage/'.$image; 
                $subadmin->image          = $uploaded_image;
            }
        }

        $subadmin->name          = $request->name;
        $subadmin->email         = $request->email;
        if($request->password)
        {
            $subadmin->password      = Hash::make($request->password);
            $subadmin->send_password     = $request->password;
        }
        $subadmin->type          = $request->role;
        $subadmin->is_super_admin  =  0 ;
        if($subadmin->update())
        {
            $subadmin->roles()->detach();
            $subadmin->assignRole($request->role);
        }

        return redirect()->route('admin.subadmin.index')->with('success','Sub-Admin Update!');
    }

   
    public function destroy($id)
    {
        $subadmin=Admin::find($id);
        $subadmin->delete();
        return redirect()->route('admin.subadmin.index')->with('success','Admin User deleted successfully');
    }
}

