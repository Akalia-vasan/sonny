<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\State;
use App\Models\Center;
use App\Models\Doctor;
use App\Models\Speciality;
use Illuminate\Support\Str;
use App\Models\DoctorAwards;
use App\Models\DoctorClinic;
use Illuminate\Http\Request;
use phpseclib3\Crypt\Random;
use App\Models\DoctorEducation;
use App\Models\DoctorExperiance;
use App\Models\DoctorMembership;
use App\Models\DoctorRegistration;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Entity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class DoctorController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:doctor-list|doctor-create|doctor-edit|doctor-delete', ['only' => ['index','storeDoctor']]);
        $this->middleware('permission:doctor-create', ['only' => ['addDoctor','storeDoctor']]);
        $this->middleware('permission:doctor-edit', ['only' => ['editDoctor','updateDoctor']]);
        $this->middleware('permission:doctor-delete', ['only' => ['deleteDoctor']]);
    }

    public function getcity(Request $request)
    {
        $cities = getcities($request->state_id);
        return response()->json([
            'cities'    =>  $cities
        ]);
    }
    public function index()
    {
        $data['alldoctor']=Doctor::get();
        return view('admin.doctor.index',$data);
    }

    public function addDoctor()
    {
        $data['areas'] = Area::all();
        $data['department']=Speciality::all();
        $data['entities']=Entity::active()->get();
        return view('admin.doctor.add',$data);
    }
    
    public function storeDoctor(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'type' => 'required|string|max:255',
            'entity_id' => 'sometimes|not_in:0',
            'name' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'dob' => 'required|date_format:Y-m-d|before:20 years',
            'gender' => 'required|in:Female,Male',
            'email' => 'required|email|unique:doctors',
            'mobile' => 'required|regex:/[6789][0-9]{9}/|unique:doctors',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'required|string|max:255',
            // 'state' => 'required|not_in:0',
            // 'zip' => 'required|numeric',
            // 'city' => 'required|not_in:0',
            'area' => 'required|not_in:0',
            'rating_option' =>'required|in:price_free,custom_price',
            'price' =>'sometimes|nullable',
            'services' => 'required|string',
            'specialist' => 'required|string',
            'clinic_name' => 'required|string',
            'clinic_address' => 'required|string',
            'clinic_images' => 'required',
            'clinic_images.*' => 'image|mimes:jpg,png,jpeg|max:3000',
            'college_name.*' => 'required|string',
            'college_degree.*' => 'required|string',
            'college_year.*' => 'required',
            'registration_name.*' => 'required|string',
            'registration_year.*' => 'required',
            'membership.*' => 'required|string',
            'award_name.*' => 'required|string',
            'award_year.*' => 'required',
            'hospital_name.*' => 'required|string',
            'start_from.*' => 'required',
            'start_to.*' => 'required',
            'designation.*' => 'required|string',
        ]);
        // dd($request->all());
        if($validator->fails())
        {
        	return redirect()->back()->withErrors($validator->errors())->withInput();
        } 
        $password =Str::random(8);
        $doctor = new Doctor;
        $doctor->entity_id = $request->entity_id?$request->entity_id:null;
        $doctor->type = $request->type;
        $doctor->name = $request->name;
        $doctor->l_name = $request->lname;
        $doctor->gender = $request->gender;
        $doctor->email = $request->email;
        $doctor->speciality_id  = $request->speciality_id ;
        $doctor->mobile = $request->mobile;
        $doctor->password = Hash::make($password);
        $doctor->send_password = $password;
        $doctor->price = $request->price !=null ? $request->price : 0;
        $doctor->dob = $request->dob;
        $doctor->about = $request->about_me;
        $doctor->services = $request->services;
        $doctor->specialisations = $request->specialist;
        $doctor->address_line1 = $request->address_line1;
        $doctor->address_line2 = $request->address_line2;
        $doctor->area_id  = $request->area;
        // $doctor->state_id  = $request->state;
        // $doctor->city_id  = $request->city;
        // $doctor->pin_code  = $request->zip;
        $doctor->active = 1;
        if($doctor->save())
        {
            for($i=0;$i<count($request->membership);$i++)
            {
                    $doctoramem = new DoctorMembership;
                    $doctoramem->doctor_id   = $doctor->id;
                    $doctoramem->membership = $request->membership["$i"];
                    $doctoramem->save();
            }
            if(count($request->award_name) == count($request->award_year))
            {
                for($i=0;$i<count($request->award_name);$i++)
                {
                    $doctoraward = new DoctorAwards;
                    $doctoraward->doctor_id   = $doctor->id;
                    $doctoraward->award = $request->award_name["$i"];
                    $doctoraward->year = $request->award_year["$i"];
                    $doctoraward->save();
                }
               
            }
            if(count($request->registration_name) == count($request->registration_year))
            {
                for($i=0;$i<count($request->registration_name);$i++)
                {
                    $doctoraregis = new DoctorRegistration;
                    $doctoraregis->doctor_id   = $doctor->id;
                    $doctoraregis->registration = $request->registration_name["$i"];
                    $doctoraregis->year = $request->registration_year["$i"];
                    $doctoraregis->save();
                }
            }
            if(count($request->college_name) == count($request->college_degree) && count($request->college_degree) == count($request->college_year) )
            {
                for($i=0;$i<count($request->college_name);$i++)
                {
                    $doctoraedu = new DoctorEducation;
                    $doctoraedu->doctor_id   = $doctor->id;
                    $doctoraedu->college = $request->college_name["$i"];
                    $doctoraedu->degree = $request->college_degree["$i"];
                    $doctoraedu->year = $request->college_year["$i"];
                    $doctoraedu->save();
                }
            }
            
            if(count($request->hospital_name) == count($request->designation))
            {
                for($i=0;$i<count($request->hospital_name);$i++)
                {
                    $doctorexperience = new DoctorExperiance;
                    $doctorexperience->doctor_id = $doctor->id;
                    $doctorexperience->hospital_name = $request->hospital_name["$i"];
                    $doctorexperience->start_from = $request->start_from["$i"];
                    $doctorexperience->start_to = $request->start_to["$i"];
                    $doctorexperience->designation = $request->designation["$i"];
                    $doctorexperience->save();
                }
            }    

            $backupLoc='public/ClinicImage/'.$doctor->id;
            if(!is_dir($backupLoc)) {
                Storage::makeDirectory($backupLoc, 0755, true, true);
            }

             $uploadimage = [];
             $files = $request->file('clinic_images');
             foreach($files as $file) 
             { 
                 $name =time().'_'.$file->getClientOriginalName();
                 $image_uploaded_path = $file->storeAs($backupLoc,$name);  
                     
                 array_push($uploadimage, $name);
             }
            $doctorclinic = new DoctorClinic;
            $doctorclinic->doctor_id = $doctor->id;
            $doctorclinic->clinic_name = $request->clinic_name;
            $doctorclinic->clinic_address = $request->clinic_address;
            $doctorclinic->clinic_images = json_encode($uploadimage,true);
            $doctorclinic->save();
            $details = [
                'email' => $doctor->email,
                'password'=> $doctor->send_password,
            ];
            try
            {
                Mail::to($request->email)->send(new \App\Mail\InstructorCredential($details));
            } catch (Exception $e) {}
            
        }
        return redirect()->route('admin.doctor')->with('success','Doctor Added!');
    }
    
    public function editDoctor($id)
    {
        $data['areas'] = Area::all();
        $data['department']=Speciality::all();
        $data['editdoctor']=Doctor::where('id',$id)->first();
        $data['entities']=Entity::active()->get();
        if($data['editdoctor']->entity_id!=null)
        {
            $data['selentity'] = Entity::where('type',$data['editdoctor']->type)->get();
        }
        $data['selectedcities']=City::where('state_id',$data['editdoctor']->state_id)->get();
        return view('admin.doctor.edit',$data);
    }
    
    public function updateDoctor(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'entity_id' => 'sometimes|not_in:0',
            'name' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'dob' => 'required|date_format:Y-m-d|before:20 years',
            'gender' => 'required|in:Female,Male',
            'email' => "required|email|unique:doctors,email,$id",
            'mobile' => "required|regex:/[6789][0-9]{9}/|unique:doctors,mobile,$id",
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'required|string|max:255',
            // 'state' => 'required|not_in:0',
            // 'zip' => 'required|numeric',
            // 'city' => 'required|not_in:0',
            'area' => 'required|not_in:0',
            'rating_option' =>'required|in:price_free,custom_price',
            'price' =>'sometimes|nullable',
            'services' => 'required|string',
            'specialist' => 'required|string',
            'clinic_name' => 'required|string',
            'clinic_address' => 'required|string',
            'clinic_images' => 'sometimes|nullable',
            'clinic_images.*' => 'image|mimes:jpg,png,jpeg|max:3000',
            'college_name.*' => 'required|string',
            'college_degree.*' => 'required|string',
            'college_year.*' => 'required',
            'registration_name.*' => 'required|string',
            'registration_year.*' => 'required',
            'membership.*' => 'required|string',
            'award_name.*' => 'required|string',
            'award_year.*' => 'required',
            'hospital_name.*' => 'required|string',
            'start_from.*' => 'required',
            'start_to.*' => 'required',
            'designation.*' => 'required|string',
        ]);
           
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }
        // dd($request->all());
        $doctor = Doctor::where('id',$id)->first();
        $doctor->entity_id = $request->entity_id?$request->entity_id:null;
        $doctor->type = $request->type;
        $doctor->name = $request->name;
        $doctor->l_name = $request->lname;
        $doctor->gender = $request->gender;
        $doctor->email = $request->email;
        $doctor->speciality_id  = $request->speciality_id;
        $doctor->mobile = $request->mobile;
        $doctor->price = $request->price !=null ? $request->price : 0;
        $doctor->dob = $request->dob;
        $doctor->about = $request->about_me;
        $doctor->services = $request->services;
        $doctor->specialisations = $request->specialist;
        $doctor->address_line1 = $request->address_line1;
        $doctor->address_line2 = $request->address_line2;
        $doctor->area_id  = $request->area;
        // $doctor->state_id  = $request->state;
        // $doctor->city_id  = $request->city;
        // $doctor->pin_code  = $request->zip;
        $doctor->active = 1;
        if($doctor->save())
        {
            DoctorMembership::where('doctor_id',$id)->delete();
            for($i=0;$i<count($request->membership);$i++)
            {
                    $doctoramem = new DoctorMembership;
                    $doctoramem->doctor_id   = $doctor->id;
                    $doctoramem->membership = $request->membership["$i"];
                    $doctoramem->save();
            }
            if(count($request->award_name) == count($request->award_year))
            {
                DoctorAwards::where('doctor_id',$id)->delete();
                for($i=0;$i<count($request->award_name);$i++)
                {
                    $doctoraward = new DoctorAwards;
                    $doctoraward->doctor_id   = $doctor->id;
                    $doctoraward->award = $request->award_name["$i"];
                    $doctoraward->year = $request->award_year["$i"];
                    $doctoraward->save();
                }
               
            }
            if(count($request->registration_name) == count($request->registration_year))
            {
                DoctorRegistration::where('doctor_id',$id)->delete();
                for($i=0;$i<count($request->registration_name);$i++)
                {
                    $doctoraregis = new DoctorRegistration;
                    $doctoraregis->doctor_id   = $doctor->id;
                    $doctoraregis->registration = $request->registration_name["$i"];
                    $doctoraregis->year = $request->registration_year["$i"];
                    $doctoraregis->save();
                }
            }
            if(count($request->college_name) == count($request->college_degree) && count($request->college_degree) == count($request->college_year) )
            {
                DoctorEducation::where('doctor_id',$id)->delete();
                for($i=0;$i<count($request->college_name);$i++)
                {
                    $doctoraedu = new DoctorEducation;
                    $doctoraedu->doctor_id   = $doctor->id;
                    $doctoraedu->college = $request->college_name["$i"];
                    $doctoraedu->degree = $request->college_degree["$i"];
                    $doctoraedu->year = $request->college_year["$i"];
                    $doctoraedu->save();
                }
            }
            
            if(count($request->hospital_name) == count($request->designation))
            {
                DoctorExperiance::where('doctor_id',$id)->delete();
                for($i=0;$i<count($request->hospital_name);$i++)
                {
                    $doctorexperience = new DoctorExperiance;
                    $doctorexperience->doctor_id = $doctor->id;
                    $doctorexperience->hospital_name = $request->hospital_name["$i"];
                    $doctorexperience->start_from = $request->start_from["$i"];
                    $doctorexperience->start_to = $request->start_to["$i"];
                    $doctorexperience->designation = $request->designation["$i"];
                    $doctorexperience->save();
                }
            }    

            $backupLoc='public/ClinicImage/'.$doctor->id;
            if(!is_dir($backupLoc)) {
                Storage::makeDirectory($backupLoc, 0755, true, true);
            }

            $doctorclinic = DoctorClinic::where('doctor_id',$id)->first();

             $uploadimage = [];
             $files = $request->file('clinic_images');
             if($request->hasFile('clinic_images'))
             {
                foreach($files as $file) 
                { 
                    $name =time().'_'.$file->getClientOriginalName();
                    $image_uploaded_path = $file->storeAs($backupLoc,$name);  
                        
                    array_push($uploadimage, $name);
                }
            }
             $allImages = [];
 
             if($doctorclinic && $doctorclinic->clinic_images)
             {
                 $images = json_decode($doctorclinic->clinic_images,true);
                 
                 $allImages = array_values(array_unique(array_merge($images, $uploadimage), SORT_REGULAR));
             }
             else
             {
                 $allImages = $uploadimage;
             }
            $doctorclinic->doctor_id = $doctor->id;
            $doctorclinic->clinic_name = $request->clinic_name;
            $doctorclinic->clinic_address = $request->clinic_address;
            $doctorclinic->clinic_images = json_encode($allImages,true);
            $doctorclinic->save();
        }
        return redirect()->route('admin.doctor')->with('success','Doctor Update!');
    }
        
    public function deleteDoctor($id)
    {
        // dd($id);
        Doctor::where('id',$id)->delete();
        return redirect()->back()->with('success','Doctor Deleted!');
    }

    public function getentity(Request $request)
    {
        $entities = Entity::where('type',$request->state_id)->get();
        return response()->json([
            'cities'    =>  $entities
        ]);
        // return response()->json($entities);
    }

    public function deleteclinicImage($id,$name)
    {
        if($id!=null && $name!=null)
        {
            $doctor = Doctor::where('id',$id)->first();
            $images = json_decode($doctor->doctorclinics->clinic_images,true);
            $filePath = public_path('storage/ClinicImage/'.$id.'/'.$name);
                if(file_exists($filePath))
                {
                    unlink($filePath);  
                }
            if (($key = array_search($name, $images)) !== false) {
                unset($images[$key]);
                $doctorclinic = DoctorClinic::where('doctor_id',$id)->first();
                $doctorclinic->clinic_images = json_encode($images,true); 
                $doctorclinic->save();
            }
        }
        return redirect()->back();
    }
    
    public function showDoctor($id)
    {
        $data['doctordata']= Doctor::where('id',$id)->first();
        return view('admin.doctor.show',$data);
    }

}
