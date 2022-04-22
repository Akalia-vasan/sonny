<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\Enquiry;
use App\Models\AppContent;
use App\Models\Instructor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\FrequentlyAskQuestion;
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
    
    public function password_reset(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);
        if(User::where('email',$request->email)->count()>0)
        {
            $token = Str::random(64);

            $pass = new PasswordReset;
            $pass->email = $request->email;
            $pass->token = $token;
            $pass->created_at =now();
            if($pass->save())
            {
                $url = url('password_reset').'/'.$token;
                $details = [
                    'url' => $url,
                ];
                try
                {
                    Mail::to($request->email)->send(new \App\Mail\PasswordResetMail($details));
                } 
                catch (Exception $e) 
                {
                    return res_failed('Email Not Sent!');
                }
                return res_success('Thank you,Password Reset Link Sent Your e-mail Successfully!');
            }
        }
        elseif(Instructor::where('email',$request->email)->count()>0)
        {
            $token = Str::random(64);

            $pass = new PasswordReset;
            $pass->email = $request->email;
            $pass->token = $token;
            $pass->created_at =now();
            if($pass->save())
            {
                $url = url('password_reset').'/'.$token;
                $details = [
                    'url' => $url,
                ];
                try
                {
                    Mail::to($request->email)->send(new \App\Mail\PasswordResetMail($details));
                } 
                catch (Exception $e) 
                {
                    return res_failed('Email Not Sent!');
                }
                return res_success('Thank you,Password Reset Link Sent Your e-mail Successfully!');
            }
        }
        else
        {
            throw ValidationException::withMessages([
                'email' => 'The selected email is invalid.',
            ]);
        }
        return res_failed('Data Not Saved!');
    }

    
    public function getTermCondition(Request $request)
    {
        $content = AppContent::where('key','term_condition')->get();

        if(count($content)>0)
        {
            return res_success('Success!',['Term_Condition'=>$content]);
        }
        else
        {
            return res_failed('Data Not Available!');
        }
    }

    public function getPrivacyPolicy(Request $request)
    {
        $content = AppContent::where('key','privacy_policy')->get();

        if(count($content)>0)
        {
            return res_success('Success!',['Privacy_Policy'=>$content]);
        }
        else
        {
            return res_failed('Data Not Available!');
        }
    }

    public function getDisclaimer(Request $request)
    {
        $content = AppContent::where('key','disclaimer')->get();

        if(count($content)>0)
        {
            return res_success('Success!',['Disclaimer'=>$content]);
        }
        else
        {
            return res_failed('Data Not Available!');
        }
    }

    public function contact_store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required',
            'comment' => 'required',
        ]);

        $enquiry= new Enquiry;
        $enquiry->name = $request->name;
        $enquiry->email = $request->email;
        $enquiry->mobile = $request->mobile;
        $enquiry->subject = 'New enquiry from User';
        $enquiry->comment = $request->comment;
        if($enquiry->save())
        {
            return res_success('Thank you for contacting us – we will get back to you soon!');
        }
        return res_failed('Enquiry Not Sent!');
    }

    public function getFaq(Request $request)
    {
        $faq=FrequentlyAskQuestion::leftjoin('faq_categories','frequently_ask_questions.category_id','=','faq_categories.id')
        ->select('frequently_ask_questions.id','frequently_ask_questions.category_id','faq_categories.name',
        'frequently_ask_questions.question','frequently_ask_questions.answer','frequently_ask_questions.active')
        ->get();
        if(count($faq)>0)
        {
            return res_success('Success!',['FAQ'=>$faq]);
        }
        else
        {
            return res_failed('Data Not Available!');
        }
    }
    
}
