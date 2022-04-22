<?php

namespace App\Http\Controllers;

use App\Models\Bed;
use App\Models\Blog;
use App\Models\City;
use App\Models\Doctor;
use App\Models\BedType;
use App\Models\Hospital;
use App\Models\Speciality;
use App\Models\BlogComment;
use App\Models\BlogCategory;
use App\Models\NurseBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    public function index()
    {
        $data['speciality']=Speciality::all();
        $data['allblog']=Blog::where('active',1)->limit(4)->latest()->get();
        $data['doctor']=Doctor::with('getRating')->get();
        return view('welcome',$data);
    }

    public function search(Request $request)
    {
        $data['special']=$request->special;
        $data['allblog']=Blog::where('active',1)->limit(4)->latest()->get();
        $data['city']=City::where('id', $request->city)->first();
        $data['city_id']=$request->city;
        // $data['speciality']=Speciality::all();
        // $query =Doctor::with(['getRating','getSpeciality']);
        // if($request->city){
        //     $query->where('city_id',$request->city);
        // }
        // if($request->special){ 
        //     $query->where('specialisations','like', '%'.$request->special.'%');
        // }               
        // $data1=$query->get();
        //dd($data1);
        // $data['doctor'] = $data1;
        return view('search',$data);
    }

    // function fetch(Request $request)
    // {
    //     $str = "";
    //     if ($request->has('str')) {
    //         $str = $request->str;
    //     }
    //         $name='amet';
    //         $data = City::where('name','like', '%'.$str.'%')->orderBy('name', 'ASC')->limit(10)->get();
    //             //return $data;
    //         $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
    //         foreach($data as $row)
    //         {
    //         $output .= '<li style="margin-left:7px;" ><a onclick="cityName('.$row->id.')" id="'.$row->id.'" data-name="'.$row->name.'" href="javascript:void(0)">'.$row->name.'</a></li>';
    //         }
    //         $output .= '</ul>';
    //         echo $output;
            
    // }
    function fetch(Request $request)
    {
            $name=$request->term;
            $data = City::where('name','like', '%'.$name.'%')->orderBy('name', 'ASC')->limit(10)->get();
            return json_decode($data);
    }
    public function search_bed(Request $request) 
    {
        // dd($request->all());
        $query = Bed::join('hospitals','hospitals.id','beds.hospital_id');
        if($request->get('location')){ 
            $query->where('hospitals.google_address','like', '%'.$request->get('location').'%');
        }  
        if($request->get('hospital_type')){
            $query->whereIn('hospitals.type',$request->get('hospital_type'));
        }
        if($request->get('bed_type')){
            $query->whereIn('beds.bed_type_id',$request->get('bed_type'));
        }
             
        $data1=$query->get();
        
        // $data['specialities'] = $request->get('special')?$request->get('special'):'';
        // dd($data);
        $data['allbedtype']=BedType::all();
        $data['allbed']=$data1;
        return view('available_beds',$data);
    }
    public function search1(Request $request) 
    {
        $data['allblog']=Blog::limit(4)->latest()->get();
        $data['special']=$request->special;
        $data['city']=City::where('id', $request->city)->first();
        $data['city_id']=$request->city;
        //$data['speciality']=Speciality::all();
        $query =Doctor::with(['getRating','getSpeciality']);
        if($request->get('city')){
            $query->where('city_id',$request->get('city'));
        }
        if($request->get('gender')){
            $query->where('gender',$request->get('gender'));
        }
        if($request->get('speciality')){
            $query->whereIn('speciality_id',$request->get('speciality'));
        }
        if($request->get('special')){ 
            $query->where('specialisations','like', '%'.$request->get('special').'%');
        }               
        $data1=$query->get();
        //dd($data1);
        $data['count'] = count($data1);
        $data['specialities'] = $request->get('special')?$request->get('special'):'';
        //dd($data);
        $record =  '';
        foreach($data1 as $doctors){
          $record .=   '<div class="card">
                            <div class="card-body">
                                <div class="doctor-widget">
                                    <div class="doc-info-left">
                                        <div class="doctor-img">
                                            <a href="'.url('doctor-profile').'/'.$doctors->id.'">';
                                            if ($doctors->profile_image){
                                                $record .=    '<img class="img-fluid" alt="User Image" src="'.$doctors->profile_image.'">';	
                                            }else{
                                                $record .=    '<img class="img-fluid" alt="User Image" src="'.asset('assets/img/doctors/doctor-thumb-01.jpg').'">';
                                            }
                                            $record .='</a>
                                        </div>
                                        <div class="doc-info-cont">
                                            <h4 class="doc-name"><a href="'.url('doctor-profile').'/'.$doctors->id.'">Dr. '.$doctors->name.' '.$doctors->l_name. '</h4>
                                            <p class="doc-speciality">' .$doctors->email. '</p>
                                            <h5 class="doc-department">
                                                <img src="'.$doctors->getSpeciality->sp_image.'" class="img-fluid" alt="Speciality">
                                                '.$doctors->getSpeciality->sp_name.'
                                            </h5>
                                            <div class="rating">';
                                            for($i=0;$i<$doctors->getRating->avg('rating');$i++){
                                                $record .='<i class="fas fa-star filled"></i>';
                                            }
                                            for($i=$doctors->getRating->avg('rating');$i<5;$i++){
                                                $record .='<i class="fas fa-star"></i>';
                                            }
                                        $record .='<span class="d-inline-block average-rating">('.$doctors->getRating->count().')</span>
                                            </div>
                                            <div class="clinic-details">
                                                <p class="doc-location"><i class="fas fa-map-marker-alt"></i> ';
                                                if($doctors->city_id != null) {
                                                      $record .= $doctors->getcity->name.' , '; 
                                                }  
                                                if($doctors->state_id != null) {
                                                    $record .= $doctors->getstate->name.' , '; 
                                                }  
                                                $record .= $doctors->getcountry->name;
                                                
                                                $record .='</p>
                                                <ul class="clinic-gallery">';
                                                if ($doctors->doctorclinics && $doctors->doctorclinics->clinic_images!=null){
                                                        $images = json_decode($doctors->doctorclinics->clinic_images,true);
                                                        $array = is_array($images) ? $images : [] ;
                                                   
                                                    foreach ($array as $array1){
                                                        $imageurl = 'storage/ClinicImage/'.$doctors->id.'/'.$array1; 
                                                        $record .= '<li>
                                                                        <a href="javascript:void(0)" data-fancybox="gallery">
                                                                            <img src="'.url($imageurl).'" alt="Feature">
                                                                        </a>
                                                                    </li>';
                                                     }                                                   
                                                }
                                                $record .= '</ul>
                                            </div>
                                            <div class="clinic-services">';
                                            $specialization = explode(',',$doctors->specialisations);
                                            $specialization = is_array($specialization)?$specialization:[];
                                            foreach ($specialization as $specialization1){
                                                $record .= '<span class="mb-2"> '.$specialization1.' </span>';
                                            }
                                            $record .= '</div>
                                        </div>
                                    </div>
                                    <div class="doc-info-right">
                                        <div class="clini-infos">
                                            <ul>
                                                <li><i class="far fa-thumbs-up"></i>'.(($doctors->getRating->avg('rating')*100)/5).'</li>
                                                <li><i class="far fa-comment"></i> '.$doctors->getRating->count().' Feedback</li>
                                                <li><i class="fas fa-map-marker-alt"></i>';
                                                if($doctors->city_id != null) {
                                                        $record .= $doctors->getcity->name.' , '; 
                                                }  
                                                if($doctors->state_id != null) {
                                                    $record .= $doctors->getstate->name.' , '; 
                                                }  
                                                $record .= $doctors->getcountry->name;
                                                $record .= '</li>
                                                <li><i class="far fa-money-bill-alt"></i> ₹ '.$doctors->price.' <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i> </li>
                                            </ul>
                                        </div>
                                        <div class="clinic-booking">
                                            <a class="view-pro-btn" href="'.url('doctor-profile').'/'.$doctors->id.'">View Profile</a>
                                            <a class="apt-btn" href="'.url('book').'/'.$doctors->id.'">Book Appointment</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
        }
        $data['record'] = $record;
        return $data;
    }
    public function profile($id)
    {
        $data['doctordata']=Doctor::find($id);
        return view('doctor-profile',$data);
    }

    public function book($id)
    {
        $data['doctor']=Doctor::with('getRating')->where('id',$id)->first();
        return view('book',$data);
    }
    public function blog() 
    {
        $data['speciality']=Speciality::all();
        $data['allblog']=Blog::where('active',1)->paginate(6);
        $data['latestblog']=Blog::where('active',1)->latest()->limit(5)->get();
        $data['blogcategory'] = Blog::groupBy('category_id')->select('category_id', DB::raw('count(*) as total'))->get();
        return view('blog',$data);
    }

    public function blogdetail($id)
    {
        $data['allblog']=Blog::where('id',$id)->first();
        $data['allblogcomment']=BlogComment::where('blog_id',$id)->get();
        $data['latestblog']=Blog::where('active',1)->latest()->limit(5)->get();
        $data['blogcategory'] = Blog::groupBy('category_id')->select('category_id', DB::raw('count(*) as total'))->get();
        return view('blogdetail',$data);   
    }

    public function blogComment(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'blog_id'       => 'required|not_in:0',
            'name'  => 'required|string',
            'email'  => 'required|email',
            'comment' => 'required|string',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }  
        $addcomment = new BlogComment();
        $addcomment->blog_id  = $request->blog_id;
        $addcomment->name  = $request->name;
        $addcomment->email  = $request->email;
        $addcomment->comment  = $request->comment;
        $addcomment->save();

        return redirect()->back()->with('success','Thank You For Your Comment!');
    }

    public function avaibleBed()
    {
        $data['hospitals']=Hospital::all();
        $data['allbedtype']=BedType::all();
        $data['allbed']=Bed::all();
        return view('available_beds',$data);
    }

    public function avaibleBedDetails($id)
    {
        $data['hospitals']=Hospital::all();
        $data['allbedtype']=BedType::all();
        $data['allbed']=Bed::where('id',$id)->first();
        return view('bed_details',$data);
    }

    public function book_nurse(Request $request)
    {
        return view('nurse_profile');
    }

    public function save_nurse_booking(Request $request)
    {

        $validator=Validator::make($request->all(),[
            'user_name'  => 'required|string',
            'user_mobile'  => 'required|numeric',
            'nurse_type' => 'required',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }  

        $nurse_table = new NurseBooking();
        $nurse_table->user_name  = $request->user_name;
        $nurse_table->user_mobile  = $request->user_mobile;
        $nurse_table->nurse_type  = $request->nurse_type;
        $nurse_table->location  = $request->location;
        $nurse_table->status  = 0;
        $nurse_table->save();

        return redirect()->back()->with('success','Your Request has been submitted ! Our customer Service will you as soon as possible Thanks!');
    }
}
