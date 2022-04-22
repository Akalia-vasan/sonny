<?php

namespace App\Http\Controllers\API\Doctor;

use Carbon\Carbon;
use App\Models\Area;
use App\Models\City;
use App\Models\User;
use App\Models\Admin;
use App\Models\State;
use App\Models\Doctor;
use App\Models\Setting;
use App\Models\UserOrder;
use App\Models\UserWallet;
use App\Models\SlotHistory;
use App\Models\DoctorWallet;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\DoctorFeedback;
use App\Models\UserBookedSlot;
use App\Models\UserMedicalRecord;
use App\Models\PrescriptionDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public function index()
    {
        $data['setting'] = UserOrder::leftjoin('user_booked_slots','user_booked_slots.order_id','user_orders.id')
                                    ->get();
        $data['setting'] = Setting::count();
        $data['breadcrumb'] =   "Dashboard";
        $data['slots'] = UserBookedSlot::join('doctor_slots','doctor_slots.id','user_booked_slots.slot_id')
        ->where('user_booked_slots.doctor_id',auth()->user()->id)
        ->whereDate('doctor_slots.booking_date','>',Carbon::today())
        ->select('user_booked_slots.id as s_id','user_booked_slots.*','doctor_slots.*')->get();
       
        $data['total_patient'] = UserBookedSlot::where('doctor_id',auth()->user()->id)->count();
        $data['today_patient'] = UserBookedSlot::where('doctor_id',auth()->user()->id)->whereDate('created_at',Carbon::today())->count();
        $data['today_appontments'] = UserBookedSlot::join('doctor_slots','doctor_slots.id','user_booked_slots.slot_id')
        ->where('user_booked_slots.doctor_id',auth()->user()->id)->whereDate('doctor_slots.booking_date',Carbon::today())->get();
        
        return res_success('Success!',['data'=>  $data]);
    }

    public function appointment()
    {
        $data['breadcrumb']=   "Appointments";
        $data['slots'] = UserBookedSlot::where('doctor_id',4)->orderBy('created_at','desc')->get();
        return res_success('Success!',['data'=>  $data]); 
    }
    public function getcity(Request $request)
    {
        $cities = getcities($request->state_id);
        return response()->json([
            'cities'    =>  $cities
        ]);
    }
    public function changeprofile()
    {
        $data['breadcrumb'] = 'Profile Settings';
        $data['areas'] = Area::all();
        return res_success('Success!',['data'=>  $data]);
    }

    public function changeSocialLink()
    {
        $data['breadcrumb'] = 'Social Media';
        return res_success('Success!',['data'=>  $data]);
    }

    public function updateprofile(Request $request)
    {
       
        $validator=Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'mobile' => 'required|regex:/[6789][0-9]{9}/|unique:doctors,mobile,'.Auth::user()->id,
            'gender' => 'required|in:Female,Male',
            'dob' => 'required|date_format:Y-m-d|before:20 years ago',
            'about'  => 'required|string',
            'address_line1'  => 'required|string',
            'address_line2'  => 'required|string',
            'profile_image'=>'sometimes|nullable|mimes:jpg,png,jpeg|max:2000',
            // 'state' => 'required|not_in:0',
            // 'pin_code' => 'required|numeric',
            // 'city' => 'required|not_in:0',
            // 'country' => 'required|not_in:0',
            'area' => 'required|not_in:0',
            'services'  => 'required|string',
            'specialist'  => 'required|string',
        ]);
        if($validator->fails())
        {
            return res_failed($validator->errors());
        }

        $backupLoc='public/Image/';
        if(!is_dir($backupLoc)) {
           Storage::makeDirectory($backupLoc, 0755, true, true);
        } 
        $doctor= Doctor::where('id',Auth::user()->id)->first(); 
        if($request->has('profile_image')) 
        {
            //Image delete
            $filePath = $doctor->profile_image;
            if($filePath != null)
            { 
               $filePath1 = storage_path('app/public/'. $filePath);
               if(is_file($filePath1))
               {
                  unlink($filePath1);
               } 
            } 
            $productfile = $request->file('profile_image');
            $profile_image = time().'_'.$productfile->getClientOriginalName();
            $upload_success1 = $request->file('profile_image')->storeAs('public/Image',$profile_image);    
            $uploaded_profile_image = 'Image/'.$profile_image; 
            $doctor->profile_image =  $uploaded_profile_image;

            $doctor->name =  $request->name;
            $doctor->l_name =  $request->l_name;
            $doctor->mobile =  $request->mobile;
            $doctor->gender =  $request->gender;
            $doctor->dob =  $request->dob;
            $doctor->about =  $request->about;
            $doctor->address_line1 =  $request->address_line1;
            $doctor->address_line2 =  $request->address_line2;
            $doctor->area_id =  $request->area;
            // $doctor->state_id =  $request->state;
            // $doctor->city_id =  $request->city;
            // $doctor->pin_code =  $request->pin_code;
            $doctor->services =  $request->services;
            $doctor->specialisations =  $request->specialist;
            $doctor->update();  
        }
        else
        {
            $doctor->name =  $request->name;
            $doctor->l_name =  $request->l_name;
            $doctor->mobile =  $request->mobile;
            $doctor->gender =  $request->gender;
            $doctor->dob =  $request->dob;
            $doctor->about =  $request->about;
            $doctor->address_line1 =  $request->address_line1;
            $doctor->address_line2 =  $request->address_line2;
            // $doctor->country_id =  $request->country;
            // $doctor->state_id =  $request->state;
            // $doctor->city_id =  $request->city;
            // $doctor->pin_code =  $request->pin_code;
            $doctor->services =  $request->services;
            $doctor->specialisations =  $request->specialist;
            $doctor->update();
        }
        return res_success('Success!',['data'=>  $doctor]);
    }

    public function updateSocialLink(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'facebook' => 'required|string|max:255',
            'twitter' => 'required|string|max:255',
            'instagram' => 'required|string|max:255',
            'pinterest' => 'required|string|max:255',
            'linkedin' => 'required|string|max:255',
            'youtube' => 'required|string|max:255',
        ]);
        if($validator->fails())
        {
            return res_failed($validator->errors());
        }

        $doctor= Doctor::where('id',Auth::user()->id)->first(); 
        $doctor->facebook =  $request->facebook;
        $doctor->twitter =  $request->twitter;
        $doctor->instagram =  $request->instagram;
        $doctor->pinterest =  $request->pinterest;
        $doctor->linkedin =  $request->linkedin;
        $doctor->youtube =  $request->youtube;
        $doctor->update();  
        return res_success('Success!',['data'=>  $doctor]);
    }

    public function changedoctorpassword()
    {
        $data['breadcrumb'] = 'Change Password';
        return view('doctor.change-password',$data);
    }

    public function updatedoctorchangepassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'password' => 'required|min:6|max:16|confirmed',
        ]);

        if($validator->fails())
        {
            return res_failed($validator->errors());
        } 
        if( ! Hash::check( $request->old_password ,auth()->user()->password) )
        {
            throw ValidationException::withMessages([
                'old_password' => 'Old Password does not match.',
            ]);
        }
        if( $request->old_password == $request->password )
        {
            throw ValidationException::withMessages([
                'password' => 'New Password can not same as Old Password.',
            ]);
        }
        $doctor = Doctor::where('email',Auth::user()->email)->first();
        $doctor->password = Hash::make($request->password);
        $doctor->send_password= $request->password;
        if($doctor->save())
        {
            Session::flash('success', "Your Password Changed Successfully!");
        }
        return res_success('Success!',['data'=>  $doctor]);

    }


    public function viewReview()
    {
        $data['breadcrumb'] = 'Reviews';
        $data['rating'] = DoctorFeedback::where('doctor_id',Auth::user()->id)->get();
        return res_success('Success!',['data'=>  $data]);
    }

    public function appointmentAccept($id)
    {
        $slots = UserBookedSlot::where('id',$id)->first();
      
        $doctorWallet = getDoctorWallet($slots->doctor_id);
        
        $doctorWallet->amount = $doctorWallet->amount + $slots->price;
        if($doctorWallet->save())
        {
            $slots->booking_status = 'Confirm';
            $slots->save();
            
            $slotHistory = new SlotHistory();
            $slotHistory->booked_slot_id =  $slots->id;
            $slotHistory->by =  'Doctor';
            $slotHistory->remark =  'Accepted By Doctor';
            $slotHistory->created_at =  now();
            $slotHistory->updated_at =  now();
            $slotHistory->save();
        }
        return res_success('Success!',['data'=>  $slotHistory]);
    }

    
    public function appointmentCancel($id)
    {
        $slots = UserBookedSlot::where('id',$id)->first();

        $userWallet = UserWallet::where('user_id',$slots->user_id)->first();
        $userWallet->amount = $userWallet->amount + $slots->price;
        if($userWallet->save())
        {
            $slots->booking_status = 'Declined';
            $slots->save();

            $slotHistory = new SlotHistory();
            $slotHistory->booked_slot_id =  $slots->id;
            $slotHistory->by =  'Doctor';
            $slotHistory->remark =  'Declined By Doctor';
            $slotHistory->created_at =  now();
            $slotHistory->updated_at =  now();
            $slotHistory->save();
        }
        return res_success('Success!',['data'=>  $slotHistory]);
    }

    public function acceptedAppointmentCancel($id)
    {
        $slots = UserBookedSlot::where('id',$id)->first();

        $doctorWallet = getDoctorWallet($slots->doctor_id); 
        $doctorWallet->amount = $doctorWallet->amount - $slots->price;
        $doctorWallet->save();
        $userWallet = UserWallet::where('user_id',$slots->user_id)->first();
        $userWallet->amount = $userWallet->amount + $slots->price;
        if($userWallet->save())
        {
            $slots->booking_status = 'Declined';
            $slots->save();

            $slotHistory = new SlotHistory();
            $slotHistory->booked_slot_id =  $slots->id;
            $slotHistory->by =  'Doctor';
            $slotHistory->remark =  'Declined By Doctor';
            $slotHistory->created_at =  now();
            $slotHistory->updated_at =  now();
            $slotHistory->save();
        }
        return res_success('Success!',['data'=>  $slotHistory]);
    }

    public function patientdetail($id) 
    {

        $data['slots'] = UserBookedSlot::where('doctor_id',auth()->user()->id)->orderBy('created_at','desc')->get();
        $data['breadcrumb']=   "Patient Profile Detail";
        $data['patients'] = User::where('id',$id)->first();
        $data['prescriptions'] = Prescription::where('user_id',$id)->orderBy('date','DESC')->get();
        $data['record']= UserMedicalRecord::where('user_id',$id)->get();
        $data['patient_id'] = $id;
       
        return res_success('Success!',['data'=> $data]);
    }

    public function saveMedicalRecord(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'attachment' => 'required|mimes:pdf',
            'user_id' => 'required|exists:users,id',
            ]
        );
        if($validator->fails())
        {
            return res_failed($validator->errors());
        }
        $user = new UserMedicalRecord();
        $user->user_id =  $request->user_id;
        $user->doctor =  Auth::user()->id;
        $user->description =  $request->description;
        if($request->has('attachment')) 
            {
                $attachment = $request->file('attachment');
                $destinationPath1 ='public/attachment/';
                $attachments = time().'_'.$attachment->getClientOriginalName();
                $upload_success1 = $request->file('attachment')->storeAs('public/attachment',$attachments);    
                $uploaded_attachment = 'attachment/'.$attachments; 
                $user->attachment =  $uploaded_attachment;
            
            }
        $user->date =  now();
        if($user->save())
        {
            Session::flash('success', 'Medical Detail Added Successfully!');
        }
        
        return res_success('Success!',['data'=> $user]);
    }

    public function addpatintPrescription($id)
    {
        $data['breadcrumb']=   "Add Prescription";
        $data['patients'] = User::where('id',$id)->first();
        $data['patient_id'] = $id;
        return view('doctor.add-prescription',$data);
    }

    public function showpatintPrescription($id)
    {
        $data['breadcrumb']=   "Show Prescription";
        $data['prescription'] = Prescription::where('id',$id)->first();
        $data['patients'] = User::where('id',$data['prescription']->user_id)->first();
        //dd($data['prescription']->getdetail);
        $data['patient_id'] = $id;

        return res_success('Success!',['data'=> $data]);
    }

    public function editpatintPrescription($id)
    {
        $data['breadcrumb']=   "Edit Prescription";
        $data['prescription'] = Prescription::where('id',$id)->first();
        $data['patients'] = User::where('id',$data['prescription']->user_id)->first();
        $data['patient_id'] = $id;
        return view('doctor.edit-prescription',$data);
    }
    public function addpatintBilling($id)
    {
        $data['breadcrumb']=   "Add Billing";
        $data['patients'] = User::where('id',$id)->first();
        $data['patient_id'] = $id;
        return view('doctor.add-billing',$data);
    }
    public function storepatintPrescription(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'medicine' => 'array',
            'qty' => 'array',
            'day' => 'array',
            'medicine.*' => 'required',
            'qty.*' => 'required',
            'day.*' => 'required',
        ]);

        if($validator->fails())
        {
        	return res_failed($validator->errors());
        } 
      
        $prescription = new Prescription();
        $prescription->user_id = $request->user_id;
        $prescription->doctor_id = $request->doctor_id;
        if($prescription->save()){
            for($i=0;$i<count($request->morning);$i++){
            $prescription_detail = new PrescriptionDetail;
            $prescription_detail->prescription_id = $prescription->id ;
            $prescription_detail->medicine = $request->medicine[$i] ;
            $prescription_detail->quantity = $request->qty[$i] ;
            $prescription_detail->days = $request->day[$i] ;
            $prescription_detail->morning = $request->morning[$i] ;
            $prescription_detail->afternoon = $request->afternon[$i] ;
            $prescription_detail->evening = $request->evening[$i] ;
            $prescription_detail->night = $request->night[$i] ;
            $prescription_detail->save();
            }

            return res_success('Success!',['data'=> $prescription_detail]);
        }

    }

    public function updatepatintPrescription(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'pres_id' => 'required|exists:prescriptions,id',
            // 'user_id' => 'required|exists:users,id',
            // 'doctor_id' => 'required|exists:doctors,id',
            'medicine' => 'array',
            'qty' => 'array',
            'day' => 'array',
            'medicine.*' => 'required',
            'qty.*' => 'required',
            'day.*' => 'required',
        ]);

        if($validator->fails())
        {
            return res_failed($validator->errors());
        } 
 
            $prescription_detail = PrescriptionDetail::where('prescription_id',$request->pres_id)->delete();
            for($i=0;$i<count($request->morning);$i++){
            $prescription_detail = new PrescriptionDetail;
            $prescription_detail->prescription_id = $request->pres_id ;
            $prescription_detail->medicine = $request->medicine[$i] ;
            $prescription_detail->quantity = $request->qty[$i] ;
            $prescription_detail->days = $request->day[$i] ;
            $prescription_detail->morning = $request->morning[$i] ;
            $prescription_detail->afternoon = $request->afternon[$i] ;
            $prescription_detail->evening = $request->evening[$i] ;
            $prescription_detail->night = $request->night[$i] ;
            $prescription_detail->save();
            }
            return res_success('Success!',['data'=> $prescription_detail]);

    }
    
}
