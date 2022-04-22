<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.enquiry.enquiry_list',$data);
    }
    public function enq_delete($id)
    {
        Enquiry::where('id',$id)->delete();
        Session::flash('success', 'Enquiry Delete');
        return redirect()->route('admin.enquiry');
    }

    public function enq_view($id)
    {
        $data["enquiry"] = Enquiry::where('id',$id)->first();
        return view('admin.enquiry.enquiry_view',$data);
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
        Session::flash('success', 'Reply Success!');
        return redirect()->route('admin.enquiry');
    }
    
}
