<?php

namespace App\Http\Controllers\API\User;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function getAllProductCategory(Request $request)
    {
        $productcategory = ProductCategory::where('active','1')->get();
        if(count($productcategory)>0)
        {
            return res_success('Success!',['Categorylist'=>$productcategory]);
        }
        else
        {
            return res_failed('Data Not Available!');
        }
    }

    public function getAllProduct(Request $request)
    {
        $product = Product::leftjoin('product_categories','products.product_cat_id','=','product_categories.id')
        ->leftjoin('centers','products.center_id','=','centers.id')
        ->select('products.*','product_categories.category_name','centers.center_name')
        ->where('products.active','1')->get();
        if(count($product)>0)
        {
            
            $productlist=[];
            foreach($product as $product1){
                $productlist[]=[
                    'id'=> $product1->id,
                    'product_name'=> $product1->product_name,
                    'product_cat_id'=> $product1->product_cat_id,
                    'category_name'=> $product1->category_name,
                    'center_id'=> $product1->center_id,
                    'center_name'=> $product1->center_name,
                    'slug'=> $product1->slug,
                    'product_image'=> $product1->product_image,
                    'product_price'=> $product1->product_price,
                    'offer_price'=> $product1->offer_price,
                    'stock'=> $product1->stock,
                    'fav'=> $product1->fav,
                    'active'=> $product1->active,
                ];
            }
            return res_success('Success!',['Productlist'=>$productlist]);
        }
        else
        {
            return res_failed('Data Not Available!');
        }
    }

    public function getProductByCategory(Request $request)
    {
        $data = $request->validate([
            'product_cat_id' => ['required', 'numeric', 'check_product_category'],
        ]);
        $product = Product::leftjoin('product_categories','products.product_cat_id','=','product_categories.id')
        ->leftjoin('centers','products.center_id','=','centers.id')
        ->select('products.*','product_categories.category_name','centers.center_name')
        ->where('products.active','1')->where('products.product_cat_id',$request->product_cat_id)->get();

        if(count($product)>0)
        {
            
            $productlist=[];
            foreach($product as $product1){
                $productlist[]=[
                    'id'=> $product1->id,
                    'product_name'=> $product1->product_name,
                    'product_cat_id'=> $product1->product_cat_id,
                    'category_name'=> $product1->category_name,
                    'center_id'=> $product1->center_id,
                    'center_name'=> $product1->center_name,
                    'slug'=> $product1->slug,
                    'product_image'=> $product1->product_image,
                    'product_price'=> $product1->product_price,
                    'offer_price'=> $product1->offer_price,
                    'stock'=> $product1->stock,
                    'fav'=> $product1->fav,
                    'active'=> $product1->active,
                ];
            }
            return res_success('Success!',['Productlist'=>$productlist]);
        }
        else
        {
            return res_failed('Data Not Available!');
        }
    }
}
