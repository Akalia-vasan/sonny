<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Area;
use App\Models\Entity;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
 
class EntityController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:entity-list|entity-create|entity-edit|entity-delete', ['only' => ['index','storeEntity']]);
        $this->middleware('permission:entity-create', ['only' => ['addEntity','storeEntity']]);
        $this->middleware('permission:entity-edit', ['only' => ['editEntity','updateEntity']]);
        $this->middleware('permission:entity-delete', ['only' => ['deleteEntity']]);
    }

    public function index()
    {
        $data['alldoctor']=Entity::get();
        return view('admin.entity.index',$data);
    }

    public function addEntity()
    {
        // $data['allrole'] = Role::all();
        $data['area']= Area::all();
        return view('admin.entity.add',$data);
    }
    
    public function storeEntity(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:entities',
            'mobile' => 'required|regex:/[6789][0-9]{9}/|unique:entities',
            'area' => 'required|not_in:0',
            'role' => 'required|not_in:0',
        ]);
        if($validator->fails())
        {
        	return redirect()->back()->withErrors($validator->errors())->withInput();
        } 

        $backupLoc='public/EntityThumbnail';
        if(!is_dir($backupLoc)) {
            Storage::makeDirectory($backupLoc, 0755, true, true);
        }

        $uploadimage = [];
        $file = $request->file('thumbnail');
        $name =time().'_'.$file->getClientOriginalName();
        $thumbnail = $file->storeAs($backupLoc,$name);     

        $backupLoc='public/EntityImages';
        if(!is_dir($backupLoc)) {
            Storage::makeDirectory($backupLoc, 0755, true, true);
        }

        $uploadimage = [];
        $files = $request->file('images');
        foreach($files as $file) 
        { 
            $name =time().'_'.$file->getClientOriginalName();
            $image_uploaded_path = $file->storeAs($backupLoc,$name);  
                
            array_push($uploadimage, $name);
        }
        $Entity = new Entity;
        $Entity->name = $request->name;
        $Entity->email = $request->email;
        $Entity->mobile = $request->mobile;
        $Entity->thumbnail = $thumbnail;
        $Entity->images = json_encode($uploadimage,true);
        $Entity->area_id  = $request->area;
        $Entity->type     = $request->role;
        $Entity->active = $request->status=="on"?1:0;
        $Entity->save();
        return redirect()->route('admin.entity')->with('success','Entity Added!');
    }
    
    public function editEntity($id)
    {
        $data['area']=Area::all();
        $data['editentity']=Entity::where('id',$id)->first();
        return view('admin.entity.edit',$data);
    }
    
    public function updateEntity(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'name'   => 'required|string|max:255',
            'email'  => "required|email|unique:entities,email,$id",
            'mobile' => "required|regex:/[6789][0-9]{9}/|unique:entities,mobile,$id",
            'area'   => 'required|not_in:0',
            'role'   => 'required|not_in:0',
        ]);
           
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }
        $Entity = Entity::where('id',$id)->first();
        if($request->has('thumbnail')){
            $backupLoc='public/EntityThumbnail';
            if(!is_dir($backupLoc)) {
                Storage::makeDirectory($backupLoc, 0755, true, true);
            }
    
            $file = $request->file('thumbnail');
            $name =time().'_'.$file->getClientOriginalName();
            $thumbnail = $file->storeAs($backupLoc,$name);   
            $Entity->thumbnail = $thumbnail; 
        }
        if($request->has('images')){
            $backupLoc='public/EntityImages';
            if(!is_dir($backupLoc)) {
                Storage::makeDirectory($backupLoc, 0755, true, true);
            }
    
            $uploadimage = [];
            $files = $request->file('images');
            foreach($files as $file) 
            { 
                $name =time().'_'.$file->getClientOriginalName();
                $image_uploaded_path = $file->storeAs($backupLoc,$name);  
                    
                array_push($uploadimage, $name);
            }
            $Entity->images = json_encode($uploadimage,true);
        }

        $Entity->name = $request->name;
        $Entity->email = $request->email;
        $Entity->mobile = $request->mobile;
        $Entity->area_id  = $request->area;
        $Entity->type     = $request->role;
        $Entity->active = $request->status=="on"?1:0;
        $Entity->save();
        return redirect()->route('admin.entity')->with('success','Entity Updated!');
    }
        
    public function deleteEntity($id)
    {
        // dd($id);
        Entity::where('id',$id)->delete();
        return redirect()->back()->with('success','Entity Deleted!');
    }

    public function deleteImage($id,$img)
    {
        if($id!=null && $img!=null)
        {
            $Entity = Entity::find($id);
            $images = json_decode($Entity->images,true);
            $filePath = public_path('storage/EntityImages/'.$img);
            // dd($filePath);
            if(file_exists($filePath))
            {
                unlink($filePath);
            }
           
            if (($key = array_search($img, $images)) !== false) {
                unset($images[$key]);
                // dd($images);
                $Entity->images = json_encode($images,true); 
                $Entity->save();
            }
        }
        return redirect()->back();
    }

    
    // public function showEntity($id)
    // {
    //     $data['doctordata']= Entity::where('id',$id)->first();
    //     return view('admin.doctor.show',$data);
    // }
}
