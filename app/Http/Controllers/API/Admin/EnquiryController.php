<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Enquiry;
use Exception;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class EnquiryController extends Controller
{
    public function index()
    {
        $data["enquiry"] = Enquiry::all();
        return res_success('Success!',['data'=> $data]);
    }
    public function enq_delete($id)
    {
        Enquiry::where('id',$id)->delete();
        return res_success('Success!',['data'=> 'Enquiry Delete']);
    }

    public function enq_view($id)
    {
        $data["enquiry"] = Enquiry::where('id',$id)->first();
        return res_success('Success!',['data'=> $data]);
    }
    public function enquiry_reply(Request $request)
    {
        $details = [
            'email' => $request->email,
            'subject'=> $request->subject,
            'reply'=> $request->reply,
        ];
        try
            {
                Mail::to($request->email)->send(new \App\Mail\EnquiryReplyMail($details));
            } catch (Exception $e) {}
        Enquiry::where('id',$request->id)->update(['reply' => $request->reply]);
      
        return res_success('Success!',['data'=> 'Reply Success!']);
    }
    
}
