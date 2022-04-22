<?php

namespace App\Http\Controllers\Admin;

use App\Models\FaqCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FrequentlyAskQuestion;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['faq']=FrequentlyAskQuestion::leftjoin('faq_categories','frequently_ask_questions.category_id','=','faq_categories.id')
        ->select('frequently_ask_questions.*','faq_categories.name','faq_categories.status')
        ->get();
        return view('admin.faq.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['faqcategory']=FaqCategory::where('status',1)->get();
        return view('admin.faq.add',$data);
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
            'category_id'  => 'required|not_in:0',
            'question'  => 'required|string',
            'answer'  => 'required|string',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }  

        $status = $request->status=='on'?1:0;
        
        $Product = new FrequentlyAskQuestion;
        $Product->category_id  = $request->category_id;
        $Product->question  = $request->question;
        $Product->answer  = $request->answer;
        $Product->active       = $status;
        $Product->save();

        return redirect()->route('admin.faq.index')->with('success','FAQ Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['faqcategory']=FaqCategory::where('status',1)->get();
        $data['faq']=FrequentlyAskQuestion::where('id',$id)->first();
        return view('admin.faq.edit',$data);
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
            'category_id'  => 'required|not_in:0',
            'question'  => 'required|string',
            'answer'  => 'required|string',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }

        $status = $request->status=='on'?1:0;

        $editproduct= FrequentlyAskQuestion::where('id',$request->id)->first();
        
            $editproduct->question  =  $request->question;
            $editproduct->answer =  $request->answer;
            $editproduct->category_id  =  $request->category_id ;
            $editproduct->active =  $status;
            $editproduct->update();
            
        return redirect()->route('admin.faq.index')->with('success','FAQ Update!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $FrequentlyAskQuestion=FrequentlyAskQuestion::find($id);
        if($FrequentlyAskQuestion->delete())
        {
            Session::flash('success','FAQ Deleted!');
            return response()->json(['status' => '1','massage'=>'FAQ Deleted!']);
        }
        else
        {
            Session::flash('failed','FAQ Not Deleted!');
            return response()->json(['status' => '0','massage'=>'FAQ Not Deleted!']);
        }
    }
}
