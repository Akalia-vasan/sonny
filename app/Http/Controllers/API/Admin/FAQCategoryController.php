<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\FaqCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FAQCategoryController extends Controller
{
    
    public function index()
    {
        $data['faqcategory'] = FaqCategory::select('*')->get();
        return res_success('Success!',['data'=> $data]);
    }

    
    public function create()
    {
        $data = [];
        return res_success('Success!',['data'=> $data]);
    }

    
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'  => 'required|string',
        ]);
        if($validator->fails())
        {
            return res_failed($validator->errors());
        }  

        $status = $request->status=='on'?1:0;

        $FaqCategory = new FaqCategory;
        $FaqCategory->name  = $request->name;
        $FaqCategory->status = $status;
        $FaqCategory->save();
        return res_success('Success!',['data'=> $FaqCategory]);
    }

    
    public function edit($id)
    {
        $data['faqcategory'] = FaqCategory::where('id',$id)->first();
        return res_success('Success!',['data'=> $data]);
    }

    
    public function update(Request $request, $id)
    {
        $validator=Validator::make($request->all(),[
            'name'  => 'required|string',
        ]);
        if($validator->fails())
        {
            return res_failed($validator->errors());
        }

        $status = $request->status=='on'?1:0;

        FaqCategory::where('id',$id)->update([
            'name'  => $request->name,
            'status'       => $status,
        ]);
        return res_success('Success!',['data'=> 'FAQ Category Update!']);
    }

    
    public function destroy($id)
    {
        $FaqCategory=FaqCategory::find($id);
        if($FaqCategory->delete())
        {
            return res_success('Success!',['status' => '1']);
        }
        else
        {
            return res_failed(['status' => '0','massage'=>'FAQ Category Not Deleted!']);
        }
    }
}
