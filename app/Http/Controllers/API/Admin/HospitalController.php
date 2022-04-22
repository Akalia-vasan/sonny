<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Hospital;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['hospitals'] = Hospital::all();
        return res_success('Success!',['data'=> $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return res_success('Success!',['data'=> '']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'hospital_name' => 'required',
            'type' => 'required',
            'address_latitude' => 'required',
            'address_longitude' => 'required',
            'hospital_number' => 'required',
            'hospital_email' => 'required',
            'hospital_address' => 'required',
            'google_address' => 'required',
            'contact_person' => 'required',
            'person_designation' => 'required',
            'person_number' => 'required',
            'about' => 'required',
            'rating' => 'required',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpg,png,jpeg',
        ]);
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        } 
          

            $backupLoc='public/HospitalImages/';
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

        $Hospital = new Hospital();
        $Hospital->hospital_name = $request->hospital_name;
        $Hospital->type = $request->type;
        $Hospital->latitude = $request->address_latitude;
        $Hospital->longitude = $request->address_longitude;
        $Hospital->hospital_number = $request->hospital_number;
        $Hospital->hospital_email = $request->hospital_email;
        $Hospital->hospital_address = $request->hospital_address;
        $Hospital->google_address = $request->google_address;
        $Hospital->contact_person = $request->contact_person;
        $Hospital->person_designation = $request->person_designation;
        $Hospital->person_number = $request->person_number;
        $Hospital->about = $request->about;
        $Hospital->rating = $request->rating;
        $Hospital->images = json_encode($uploadimage,true);
        $Hospital->save();
        return res_success('Success!',['data'=> $Hospital]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['hospital']= Hospital::where('id',$id)->first();
        return res_success('Success!',['data'=> $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['hospitals'] = Hospital::where('id',$id)->first();
        return res_success('Success!',['data'=> $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator=Validator::make($request->all(),[
            'hospital_name' => 'required',
            'type' => 'required',
            'address_latitude' => 'required',
            'address_longitude' => 'required',
            'hospital_number' => 'required',
            'hospital_email' => 'required',
            'hospital_address' => 'required',
            'google_address' => 'required',
            'contact_person' => 'required',
            'person_designation' => 'required',
            'person_number' => 'required',
            'about' => 'required',
            'rating' => 'required',
            'images' => 'sometimes|nullable',
            'images.*' => 'image|mimes:jpg,png,jpeg',
        ]);
        if($validator->fails())
        {
        	return res_failed($validator->errors());
        } 
            $Hospital = Hospital::where('id',$id)->first();

            $backupLoc='public/HospitalImages/';
            if(!is_dir($backupLoc)) {
                Storage::makeDirectory($backupLoc, 0755, true, true);
            }
            $uploadimage = [];
            $files = $request->file('images');
            if($request->hasFile('images'))
            {
                foreach($files as $file) 
                { 
                    $name =time().'_'.$file->getClientOriginalName();
                    $image_uploaded_path = $file->storeAs($backupLoc,$name);  
                        
                    array_push($uploadimage, $name);
                }
            }
            $allImages = [];

            if($Hospital && $Hospital->images)
            {
                $images = json_decode($Hospital->images,true);
                
                $allImages = array_values(array_unique(array_merge($images, $uploadimage), SORT_REGULAR));
            }
            else
            {
                $allImages = $uploadimage;
            }
            $Hospital->hospital_name = $request->hospital_name;
            $Hospital->type = $request->type;
            $Hospital->latitude = $request->address_latitude;
            $Hospital->longitude = $request->address_longitude;
            $Hospital->hospital_number = $request->hospital_number;
            $Hospital->hospital_email = $request->hospital_email;
            $Hospital->hospital_address = $request->hospital_address;
            $Hospital->google_address = $request->google_address;
            $Hospital->contact_person = $request->contact_person;
            $Hospital->person_designation = $request->person_designation;
            $Hospital->person_number = $request->person_number;
            $Hospital->about = $request->about;
            $Hospital->rating = $request->rating;
            $Hospital->images = json_encode($allImages,true);
            $Hospital->save();
            return res_success('Success!',['data'=> $Hospital]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hospital = Hospital::where('id',$id)->first();
        $hospital->delete();
        return res_success('Success!',['data'=> '']);
    }
    public function deleteImage($id,$name)
    {
        if($id!=null && $name!=null)
        {
            $hospital = Hospital::where('id',$id)->first();
            $images = json_decode($hospital->images,true);
            $filePath = public_path('storage/HospitalImages/'.$name);
                if(file_exists($filePath))
                {
                    unlink($filePath);  
                }
            if (($key = array_search($name, $images)) !== false) {
                unset($images[$key]);
                $hospitalimg = Hospital::where('id',$id)->first();
                $hospitalimg->images = $images; 
                $hospitalimg->save();
            }
        }
        return res_success('Success!',['data'=> '']);
    }
}
