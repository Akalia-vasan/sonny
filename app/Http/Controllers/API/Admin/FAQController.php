<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\FaqCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FrequentlyAskQuestion;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FAQController extends Controller
{
    
    public function index()
    {
        $data['faq']=FrequentlyAskQuestion::leftjoin('faq_categories','frequently_ask_questions.category_id','=','faq_categories.id')
        ->select('frequently_ask_questions.*','faq_categories.name','faq_categories.status')
        ->get();
        return res_success('Success!',['data'=> $data]);
    }

    
    public function create()
    {
        $data['faqcategory']=FaqCategory::where('status',1)->get();
        return res_success('Success!',['data'=> $data]);
    }

    
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'category_id'  => 'required|not_in:0',
            'question'  => 'required|string',
            'answer'  => 'required|string',
        ]);
        if($validator->fails())
        {
            return res_failed($validator->errors());
        }  

        $status = $request->status=='on'?1:0;
        
        $Product = new FrequentlyAskQuestion;
        $Product->category_id  = $request->category_id;
        $Product->question  = $request->question;
        $Product->answer  = $request->answer;
        $Product->active       = $status;
        $Product->save();

        return res_success('Success!',['data'=>  $Product]);
    }

    
    

    
    public function edit($id)
    {
        $data['faqcategory']=FaqCategory::where('status',1)->get();
        $data['faq']=FrequentlyAskQuestion::where('id',$id)->first();
        return res_success('Success!',['data'=> $data]);
    }

   
    public function update(Request $request, $id)
    {
        $validator=Validator::make($request->all(),[
            'category_id'  => 'required|not_in:0',
            'question'  => 'required|string',
            'answer'  => 'required|string',
        ]);
        if($validator->fails())
        {
            return res_failed($validator->errors());
        }

        $status = $request->status=='on'?1:0;

        $editproduct= FrequentlyAskQuestion::where('id',$request->id)->first();
        
            $editproduct->question  =  $request->question;
            $editproduct->answer =  $request->answer;
            $editproduct->category_id  =  $request->category_id ;
            $editproduct->active =  $status;
            $editproduct->update();
            
            return res_success('Success!',['data'=> $editproduct]);
    }

    
    public function destroy($id)
    {
        $FrequentlyAskQuestion=FrequentlyAskQuestion::find($id);
        if($FrequentlyAskQuestion->delete())
        {
            return res_success('Success!',['status' => '1']);
        }
        else
        {
            return res_failed(['status' => '0','massage'=>'FAQ Not Deleted!']);
        }
    }
}
