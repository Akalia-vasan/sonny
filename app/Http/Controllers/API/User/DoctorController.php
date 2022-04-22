<?php

namespace App\Http\Controllers\API\User;

use Carbon\Carbon;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\DoctorFeedback;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{

    public function getAllDoctors(Request $request)
    {
        $doctors = Doctor::all();
        if(count($doctors)>0)
        {
            $doctorlist=[];
            foreach($doctors as $doctor){
                $doctorlist[]=[
                    'id'=> $doctor->id,
                    'type'=> $doctor->getEntity->type, 
                    'name'=> $doctor->name.' '.$doctor->l_name,
                    'profile_image'=> $doctor->profile_image,
                    'email'=> $doctor->email,
                    'exp'=> getExp($doctor->id),
                    'specialisations' => $doctor->specialisations,
                    'average_rating' => round($doctor->getRating->avg('rating'),1),                 
                    'speciality' => $doctor->getspeciality->sp_name,         
                    'price' => $doctor->price,                  
                ];          
            }
            return res_success('Success!',['doctors'=>$doctorlist]);
        }
        else
        {
            return res_failed('Data Not Available!');
        }
    }

    public function getDoctorDetail(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'doctor_id'  =>  'required|numeric|exists:doctors,id',
        ]);
        if($validator->fails())
        {   
            return res_failed($validator->errors()->first());     
        }
        $doctor = Doctor::find($request->doctor_id);
        $ratings=[];
        foreach($doctor->getRating as $rating){
            $ratings[]=[
                // 'id'=> $$rating->id,
                'name'=> $rating->getUser->name,
                'profile_image'=> $rating->getUser->profile_image,
                'review'=> $rating->feedback,
                'star'=> $rating->rating,
                'date'=> $rating->created_at?Carbon::parse($rating->created_at)->format('d,M,Y'):'',
            ];  
        }

        $slots=[]; 
        for($i=0;$i<7;$i++){
            if($i==0){
                $day = Carbon::now()->adddays(+$i)->format('l');
                $alls = slots($i+1,$request->doctor_id);
                foreach($alls as $all){
                    if(Carbon::parse($all->start_time)->format('H:i')>Carbon::now()->format('H:i')){
                        $slots[]=[
                            'day'=> $day,
                            'slot_id'=> $all->id,
                            'start_time'=> Carbon::parse($all->start_time)->format('h:i A'),
                            'is_booked'=> $all->is_booked,
                            'is_active'=> $all->is_active,
                        ];
                    }
                }
            }else{
                $day = Carbon::now()->adddays(+$i)->format('l');
                $alls = slots($i+1,$request->doctor_id);
                foreach($alls as $all){
                    $slots[]=[
                        'day'=> $day,
                        'slot_id'=> $all->id,
                        'start_time'=> Carbon::parse($all->start_time)->format('h:i A'),
                        'is_booked'=> $all->is_booked,
                        'is_active'=> $all->is_active,
                    ];
                }
            }                             
        }

        $doctordetail[]=[
            'id'=> $doctor->id,
            'type'=> $doctor->getEntity->type, 
            'name'=> $doctor->name.' '.$doctor->l_name,
            'email'=> $doctor->email,
            'profile_image'=> $doctor->profile_image,
            'gender' => $doctor->gender,
            'speciality' => $doctor->getspeciality->sp_name,
            'about' => $doctor->about,
            'price' => $doctor->price,
            'specialisations' => $doctor->specialisations,
            'services' => $doctor->services,
            'average_rating' => round($doctor->getRating->avg('rating'),1),
            'average_rating' => round($doctor->getRating->avg('rating'),1),
            'reviews' => $ratings,
            'slots' => $slots,
        ];  
        return res_success('Success!',['doctor_detail'=>$doctordetail]);
    }

    public function getDoctorsByLocation(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'city_id'  =>  'required|numeric',
        ]);
        if($validator->fails())
        {   
            return res_failed($validator->errors()->first());     
        }
        $doctors = Doctor::where('city_id',$request->city_id)->get();
        if(count($doctors)>0)
        {
            $doctorlist=[];
            foreach($doctors as $doctor){
                $doctorlist[]=[
                    'id'=> $doctor->id,
                    'type'=> $doctor->getEntity->type, 
                    'name'=> $doctor->name.' '.$doctor->l_name,
                    'profile_image'=> $doctor->profile_image,
                    'email'=> $doctor->email,
                    'exp'=> getExp($doctor->id),
                    'specialisations' => $doctor->specialisations,
                    'average_rating' => round($doctor->getRating->avg('rating'),1),                 
                    'speciality' => $doctor->getspeciality->sp_name,         
                    'price' => $doctor->price,                  
                ];          
            }
            return res_success('Success!',['doctors'=>$doctorlist]);
        }
        else
        {
            return res_failed('Data Not Available!');
        }
    }
    
    public function getDoctorsBySpecialityId(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'speciality_id'  =>  'required|numeric|exists:specialities,id',
        ]);
        if($validator->fails())
        {   
            return res_failed($validator->errors()->first());     
        }
        $doctors = Doctor::where('speciality_id',$request->speciality_id)->get();
        if(count($doctors)>0)
        {
            $doctorlist=[];
            foreach($doctors as $doctor){
                $doctorlist[]=[
                    'id'=> $doctor->id,
                    'type'=> $doctor->getEntity->type, 
                    'name'=> $doctor->name.' '.$doctor->l_name,
                    'profile_image'=> $doctor->profile_image,
                    'email'=> $doctor->email,
                    'exp'=> getExp($doctor->id),
                    'specialisations' => $doctor->specialisations,
                    'average_rating' => round($doctor->getRating->avg('rating'),1),                 
                    'speciality' => $doctor->getspeciality->sp_name,         
                    'price' => $doctor->price,                  
                ];          
            }
            return res_success('Success!',['doctors'=>$doctorlist]);
        }
        else
        {
            return res_failed('Data Not Available!');
        }
    }

    public function getDoctorsBySpeciality(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'term'  =>  'required|string',
        ]);
        if($validator->fails())
        {   
            return res_failed($validator->errors()->first());     
        }
        $doctors = Doctor::where('name','like', '%'.$request->term.'%')
        ->orWhere('l_name','like', '%'.$request->term.'%')
        ->orWhere('specialisations','like', '%'.$request->term.'%')->get();
        if(count($doctors)>0)
        {
            $doctorlist=[];
            foreach($doctors as $doctor){
                $doctorlist[]=[
                    'id'=> $doctor->id,
                    'type'=> $doctor->getEntity->type, 
                    'name'=> $doctor->name.' '.$doctor->l_name,
                    'profile_image'=> $doctor->profile_image,
                    'email'=> $doctor->email,
                    'exp'=> getExp($doctor->id),
                    'specialisations' => $doctor->specialisations,
                    'average_rating' => round($doctor->getRating->avg('rating'),1),                 
                    'speciality' => $doctor->getspeciality->sp_name,         
                    'price' => $doctor->price,                  
                ];          
            }
            return res_success('Success!',['doctors'=>$doctorlist]);
        }
        else
        {
            return res_failed('Data Not Available!');
        }
    }

    public function add_review(Request $request)
    {
        //dd($request->all());
        $patient_id=auth()->user()->id;
        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'rating' => 'required|max:5',
            'type' => 'required|string|max:255',
            'feedback' => 'required|string|max:255',
        ]);

        $DoctorFeedback = new DoctorFeedback();
        $DoctorFeedback->user_id =  $patient_id;
        $DoctorFeedback->doctor_id =  $request->doctor_id;
        $DoctorFeedback->rating =  $request->rating;
        $DoctorFeedback->type =  $request->type;
        $DoctorFeedback->feedback =  $request->feedback;
        if($DoctorFeedback->save())
        {
            return res_success('Your Review Added Successfully!',);
        }
        
        return res_failed('Data Not Saved!');
    }
 
    public function getFavourite()
    {
        $doctors  = Doctor::join('user_booked_slots','user_booked_slots.doctor_id','doctors.id')
                    ->where('user_booked_slots.user_id',auth()->user()->id)->get()->unique('user_booked_slots.doctor_id');
        if($doctors)
        {    
            $data  = [];
            foreach($doctors as $doctor){
                $data[] = [
                    'id'   =>    $doctor->id,
                    'name' =>  $doctor->name.' '.$doctor->l_name,
                    'profile' =>  $doctor->profile_image,
                    'specialisation' =>  $doctor->specialisations,
                    'total_review' =>  $doctor->getRating->count(),
                    'average_rating' =>  $doctor->getRating->avg('rating')?round($doctor->getRating->avg('rating'),2):0,
                    'price' =>  $doctor->price
                ];
            }
            return res_success('SUCCESS!',['Favourite-Doctors'=>$data]);
        }
        return res_failed('Data Not Saved!');
    }
}
