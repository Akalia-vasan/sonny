<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Center;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['product']=Product::leftjoin('centers','products.center_id','=','centers.id')
        ->leftjoin('product_categories','products.product_cat_id','=','product_categories.id')
        ->select('products.*','product_categories.category_name','centers.center_name')
        ->get();
        return res_success('Success!',['data'=> $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['center']=Center::where('active',1)->get();
        $data['productcategory']=ProductCategory::where('active',1)->get();
        return res_success('Success!',['data'=> $data]);
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
            'product_cat_id'  => 'required|not_in:0',
            'center_id'  => 'required|not_in:0',
            'product_name'  => 'required|string',
            'product_image'  => 'required||mimes:jpg,png,jpeg',
            'product_price'  => 'required|string',
            'offer_price'  => 'required|string',
            'stock'  => 'required|string',
        ]);
        if($validator->fails())
        {
            return res_failed($validator->errors());
        }  

        $status = $request->status=='on'?1:0;
        $fav = $request->fav=='on'?1:0;
        
        $backupLoc='public/productImage/';
        if(!is_dir($backupLoc)) {
           Storage::makeDirectory($backupLoc, 0755, true, true);
        }
                
        $logofile = $request->file('product_image');
        $logo_image = time().'_'.$logofile->getClientOriginalName();
        $upload_success1 = $request->file('product_image')->storeAs('public/productImage',$logo_image);    
        $uploaded_product_image = 'productImage/'.$logo_image; 
    
        $Product = new Product;
        $Product->product_cat_id  = $request->product_cat_id;
        $Product->center_id  = $request->center_id;
        $Product->product_name  = $request->product_name;
        $Product->slug  = $request->slug;
        $Product->product_image  = $uploaded_product_image;
        $Product->product_price  = $request->product_price;
        $Product->offer_price  = $request->offer_price;
        $Product->stock  = $request->stock;
        $Product->fav  = $fav;
        $Product->active       = $status;
        $Product->save();

        return res_success('Success!',['data'=> $Product]);
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
        $data['center']=Center::where('active',1)->get();
        $data['productcategory']=ProductCategory::where('active',1)->get();
        $data['product']=Product::where('id',$id)->first();
        return res_success('Success!',['data'=> $data]);
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
            'product_cat_id'  => 'required|not_in:0',
            'center_id'  => 'required|not_in:0',
            'product_name'  => 'required|string',
            'product_image'  => 'sometimes|nullable|mimes:jpg,png,jpeg',
            'product_price'  => 'required|string',
            'offer_price'  => 'required|string',
            'stock'  => 'required|string',
        ]);
        if($validator->fails())
        {
            return res_failed($validator->errors());
        }

        $status = $request->status=='on'?1:0;
        $fav = $request->fav=='on'?1:0;

        $backupLoc='public/productImage/';
        if(!is_dir($backupLoc)) {
           Storage::makeDirectory($backupLoc, 0755, true, true);
        }
        
        $editproduct= Product::where('id',$request->id)->first();
        if($request->has('product_image')) 
        {
            //Image delete
            $filePath = $editproduct->product_image;
            if($filePath != null)
            { 
               $filePath1 = storage_path('app/public/'. $filePath);
               if(is_file($filePath1))
               {
                  unlink($filePath1);
               } 
            } 
            $productfile = $request->file('product_image');
            $product_image = time().'_'.$productfile->getClientOriginalName();
            $upload_success1 = $request->file('product_image')->storeAs('public/productImage',$product_image);    
            $uploaded_product_image = 'productImage/'.$product_image; 
            $editproduct->product_image =  $uploaded_product_image;
            $editproduct->product_cat_id =  $request->product_cat_id;
            $editproduct->center_id =  $request->center_id;
            $editproduct->product_name =  $request->product_name;
            $editproduct->product_price =  $request->product_price;
            $editproduct->offer_price =  $request->offer_price;
            $editproduct->slug  = $request->slug;
            $editproduct->stock =  $request->stock;
            $editproduct->active =  $status;
            $editproduct->fav =  $fav;
            $editproduct->update();
           
        }
        else
        {
            $editproduct->product_cat_id =  $request->product_cat_id;
            $editproduct->center_id =  $request->center_id;
            $editproduct->product_name =  $request->product_name;
            $editproduct->product_price =  $request->product_price;
            $editproduct->offer_price =  $request->offer_price;
            $editproduct->slug  = $request->slug;
            $editproduct->stock =  $request->stock;
            $editproduct->active =  $status;
            $editproduct->fav =  $fav;
            $editproduct->update();
        }
        

        return res_success('Success!',['data'=> $editproduct]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Product=Product::find($id);
        if($Product->delete())
        {
            return res_success('Success!',['status' => '1']);
        }
        else
        {
            return res_failed(['status' => '0','massage'=>'Product Not Deleted!']);
        }
    }
}
