<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function getProductList()
    {
       $data= Product::select('id as product_id','product_name','product_img')->without('category','brand','subcategory','primarysupplier')->get();

       return response()->json(['products'=>$data]);
    }

}
