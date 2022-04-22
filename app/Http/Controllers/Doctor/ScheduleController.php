<?php

namespace App\Http\Controllers\Doctor;

use Carbon\Carbon;
use App\Models\Session;
use App\Models\DoctorSlot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{

    public function index()
    {
        
    }

    public function create2()
    {
        $data['breadcrumb'] = 'Add Schedule Timings';
       // $data['schedule'] =  Session::where('doctor_id',Auth::user()->id)->get(); 
        return view('doctor.schedule.add',$data);
    }
    public function create()
    {
        $data['breadcrumb'] = 'Schedule Timings';
        $data['schedule'] =  Session::where('doctor_id',Auth::user()->id)->get(); 
        return view('doctor.schedule',$data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'time' => 'required|string|max:255',
            'day' => 'required|string|max:255',
            'start_time.*' => 'required',
            'end_time.*' => 'required|after:start_time.*',
        ]);
        if($validator->fails())
        {
           //dd($validator->errors());
            return redirect()->back()->withErrors($validator->errors())->withInput(['day'=>$request->day]);
        }
        for($i=0;$i<count($request->start_time)-1;$i++)
        { 
            if($request->start_time[$i+1] >  $request->start_time[$i] && $request->start_time[$i+1] < $request->end_time[$i]){
                return redirect()->back()->with('error','Schedule Timing Timing Is Not Correct!');
            }    
        }
      // dd($request->all());
        if(count($request->start_time)==count($request->end_time)){
            for($i=0;$i<count($request->start_time);$i++)
            {
                $session= new Session(); 
                $session->doctor_id =  Auth::user()->id;
                $session->time_frame =  $request->time;
                $session->day =  $request->day;
                $session->session_name =  $request->start_time[$i].' - '.$request->end_time[$i];
                $session->start_time =  $request->start_time[$i];
                $session->end_time =  $request->end_time[$i];
                $session->save();                 
            }
        }

        return redirect()->route('doctor.schedule-timing')->with('success','Schedule Timing Added!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'time' => 'required|string|max:255',
            'day' => 'required|string|max:255',
            'start_time.*' => 'required',
            'end_time.*' => 'required|after:start_time.*',
        ]);
        if($validator->fails())
        {
           // dd($validator->errors());
            return redirect()->back()->withErrors($validator->errors())->withInput(['day'=>$request->day]);
        }
        for($i=0;$i<count($request->start_time)-1;$i++)
        { 
            if($request->start_time[$i+1] >  $request->start_time[$i] && $request->start_time[$i+1] < $request->end_time[$i]){
                dd($request->start_time[$i+1]);
                return redirect()->back()->with('error','Schedule Timing Timing Is Not Correct!');
            }    
        }
        $sess = Session::where(['doctor_id'=>Auth::user()->id,'day'=>$request->day])->get();
        $count = 0;
        foreach($sess as $sesss){
            $count =  $count + DoctorSlot::where('session_id',$sesss->id)->count(); 
        }
        if($count>0){
            return redirect()->back()->with('error','This Session Associated with Doctor Slot, delete Doctor Slot First!.');
        }
        if(isset($request->start_time) && count($request->start_time)==count($request->end_time)){
            for($i=0;$i<count($request->start_time);$i++)
            {
                $session= new Session(); 
                $session->doctor_id =  Auth::user()->id;
                $session->time_frame =  $request->time;
                $session->day =  $request->day;
                $session->session_name =  $request->start_time[$i].' - '.$request->end_time[$i];
                $session->start_time =  $request->start_time[$i];
                $session->end_time =  $request->end_time[$i];
                $session->save();                 
            }
        }

        return redirect()->route('doctor.schedule-timing')->with('success','Schedule Timing Updated!');
    }

    public function destroy($id)
    {
        //
    }

    public function slots()
    {
        $data['breadcrumb'] = 'Available Timings';
        $day = Carbon::now()->format('l');
        $data['sessions'] = Session::where('day',$day)->get(); 
        $data['slots'] =  DoctorSlot::where('doctor_id',Auth::user()->id)->whereDate('booking_date',Carbon::now())->get(); 
        $data['count'] =  DoctorSlot::where('doctor_id',Auth::user()->id)->whereDate('booking_date','<=',Carbon::now())->count(); 
        $data['date'] =  Carbon::now()->format('Y-m-d');
        //dd($data['count']);
        return view('doctor.slot',$data);
    }

    public function filterslots(Request $request)
    {
        $data['breadcrumb'] = 'Available Timings';
        $date = $request->schedule_date;
        $day = Carbon::parse($date)->format('l');
        $data['sessions'] = Session::where('day',$day)->get(); 
        $data['slots'] =  DoctorSlot::where('doctor_id',Auth::user()->id)->whereDate('booking_date',Carbon::parse($date))->get(); 
        $data['count'] =  DoctorSlot::where('doctor_id',Auth::user()->id)->whereDate('booking_date','<=',Carbon::parse($date))->count(); 
        $data['date'] =  $request->schedule_date;
        //dd($data['count']);
        return view('doctor.slot',$data);
    }

    public function createSlot()
    {  
        for($i=0;$i<7;$i++){
            $day = Carbon::now()->adddays(+$i)->format('l');
            $sessions = Session::where('day',$day)->get(); 
            $counts = DoctorSlot::where('booking_date',Carbon::now()->adddays(+$i)->format('Y-m-d'))->count();
            if($counts>0 || count($sessions)==0){
                continue;
            }
            foreach($sessions as $session){
                $start= $session->start_time;
                $end= $session->end_time;
                $totalSecondsDiff = abs(strtotime($end)-strtotime($start)); 
                $totalMinutesDiff = $totalSecondsDiff/60;
                $totalSlot = $totalMinutesDiff/$session->time_frame;
                for($j=0;$j<(int)($totalSlot);$j++){
                    $startTime = Carbon::parse($session->start_time)->addMinute(+($session->time_frame*$j))->format('H:i');
                    $endTime = Carbon::parse($session->start_time)->addMinute(+(($session->time_frame*$j)+$session->time_frame))->format('H:i');
                    $DoctorSlot = new  DoctorSlot();
                    $DoctorSlot->doctor_id = auth()->user()->id;
                    $DoctorSlot->session_id = $session->id;
                    $DoctorSlot->slot_name = $startTime.' - '.$endTime;
                    $DoctorSlot->booking_date = Carbon::now()->adddays(+$i);
                    $DoctorSlot->start_time = $startTime;
                    $DoctorSlot->end_time = $endTime;
                    $DoctorSlot->save();  
                }
            }        
        }
        return redirect()->back()->with('success','Slot Timing Added!');
    }

    public function update_slot(Request $request)
    {
        $slot = DoctorSlot::find($request->slot_id);

        if($slot->is_active==1){
            $slot->is_active = 0;
            $slot->update(); 
            return response()->json([
                'title'    =>  'Disabled!',
                'text'    =>  'This Slot Is Disabled Now.',
                'type'    =>  'warning'
            ]); 
        }else{
            $slot->is_active = 1;
            $slot->update(); 
            return response()->json([
                'title'    =>  'Enabled!',
                'text'    =>  'This Slot Is Enabled Now.',
                'type'    =>  'success'
            ]); 
        }
        
    }
}
