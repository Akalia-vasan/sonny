<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Speciality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SpecialityController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:speciality-list|speciality-create|speciality-edit|speciality-delete', ['only' => ['index','store']]);
        $this->middleware('permission:speciality-create', ['only' => ['create','store']]);
        $this->middleware('permission:speciality-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:speciality-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['speciality']=Speciality::get();
        return res_success('Success!',['data'=> $data]);
    }
    public function create()
    {
        $data=[];
        return res_success('Success!',['data'=> $data]);
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'sp_name' => 'required|string|max:255',
            'sp_image' => 'required|image|max:3000',
        ]);
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        } 
            $backupLoc='public/specialities/';
            if(!is_dir($backupLoc)) {
                Storage::makeDirectory($backupLoc, 0755, true, true);
            }
            if($request->hasFile('sp_image') && $request->has('sp_image'))
            {
                $file = $request->file('sp_image');
                $filename =time().'_'.$file->getClientOriginalName();
                $image_uploaded_path = $file->storeAs($backupLoc,$filename);  
            }

            
        $Speciality = new Speciality;
        $Speciality->sp_code = $this->generateRandomString(8);
        $Speciality->sp_name = $request->sp_name;
        $Speciality->sp_image = 'specialities/'.$filename;
        $Speciality->save();
        return res_success('Success!',['data'=> $Speciality]);
    }
    public function edit($id)
    {
        $data['editSpeciality']=Speciality::where('id',$id)->first();
        return res_success('Success!',['data'=> $data]);
    }
    public function update(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'sp_name' => 'required|string|max:255',
            'sp_image' => 'sometimes|nullable|image|max:3000',
        ]);
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        } 

            $backupLoc='public/specialities/';
            if(!is_dir($backupLoc)) {
                Storage::makeDirectory($backupLoc, 0755, true, true);
            }
            
            $Speciality = Speciality::where('id',$id)->first();
            $Speciality->sp_name = $request->sp_name;
            if($request->hasFile('sp_image') && $request->has('sp_image'))
            {
                $filePath= @$Speciality->getAttributes()['sp_image'];
        
                if($filePath != null)
                {
                    $filePath1 = storage_path('app/public/'.$Speciality->getAttributes()['sp_image']);
                    if(file_exists($filePath1)){
                        unlink($filePath1);
                    }
                }
                $file = $request->file('sp_image');
                $filename =time().'_'.$file->getClientOriginalName();
                $image_uploaded_path = $file->storeAs($backupLoc,$filename);  
           
                $Speciality->sp_image = 'specialities/'.$filename;
            }
        $Speciality->save();
        return res_success('Success!',['data'=> $Speciality]);
    }
    public function destroy($id)
    {
        $Speciality = Speciality::where('id',$id)->first();
        $filePath = public_path('storage/'.$Speciality->getAttributes()['sp_image']);
        if(file_exists($filePath))
        {
            unlink($filePath);  
        }
        $Speciality->delete();
        return res_success('Success!',['data'=> '']);
    }

    public  function generateRandomString($length = 20) 
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
