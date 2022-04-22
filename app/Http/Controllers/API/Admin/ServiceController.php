<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Models\BeautyService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:service-list|service-create|service-edit|service-delete', ['only' => ['index','store']]);
        $this->middleware('permission:service-create', ['only' => ['create','store']]);
        $this->middleware('permission:service-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:service-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['service']=BeautyService::get();
        return res_success('Success!',['data'=> $data]);
    }
    public function create()
    {
        $data =[];
        return res_success('Success!',['data'=> $data]);
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'service_name' => 'required|string|unique:beauty_services,service_name|max:255',
            'service_image' => 'required|image|max:3000',
        ]);
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        } 
        $backupLoc='public/clinic-service/';
        if(!is_dir($backupLoc)) {
            Storage::makeDirectory($backupLoc, 0755, true, true);
        }
        if($request->hasFile('service_image') && $request->has('service_image'))
        {
            $file = $request->file('service_image');
            $filename =time().'_'.$file->getClientOriginalName();
            $image_uploaded_path = $file->storeAs($backupLoc,$filename);  
        }

            
        $Speciality = new BeautyService;
        $Speciality->service_name = $request->service_name;
        $Speciality->service_image = 'clinic-service/'.$filename;
        $Speciality->save();
        return res_success('Success!',['data'=> $Speciality]);
    }
    public function edit($id)
    {
        $data['editSpeciality']=BeautyService::where('id',$id)->first();
        return res_success('Success!',['data'=> $data]);
    }
    public function update(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'service_name' => 'required|string|max:255',
            'service_image' => 'sometimes|nullable|image|max:3000',
        ]);
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        } 

            $backupLoc='public/clinic-service/';
            if(!is_dir($backupLoc)) {
                Storage::makeDirectory($backupLoc, 0755, true, true);
            }
            
            $Speciality = BeautyService::where('id',$id)->first();
            $Speciality->service_name = $request->service_name;
            if($request->hasFile('service_image') && $request->has('service_image'))
            {
                $filePath=$Speciality->getAttributes()['service_image'];
        
                if($filePath != null)
                {
                    $filePath1 = storage_path('app/public/'.$Speciality->getAttributes()['sp_image']);
                    unlink($filePath1);
                }
                $file = $request->file('service_image');
                $filename =time().'_'.$file->getClientOriginalName();
                $image_uploaded_path = $file->storeAs($backupLoc,$filename);  
           
                $Speciality->service_image = 'clinic-service/'.$filename;
            }
        $Speciality->save();
        return res_success('Success!',['data'=> $Speciality]);
    }
    public function destroy($id)
    {
        $Speciality = BeautyService::where('id',$id)->first();
        $filePath = public_path('storage/'.$Speciality->getAttributes()['service_image']);
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
