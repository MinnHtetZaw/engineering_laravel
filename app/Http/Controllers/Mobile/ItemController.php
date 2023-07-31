<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SiteItemResource;
use Illuminate\Http\Request;

use App\Models\Product;

class ItemController extends Controller
{

    public function SiteItemsInventory(Request $request)
    {

        // Show Products when even without items

        // $items =Product::with(['items'=>function ($query) use ($request){
        //     $query->where('site',2)->where('project_phase_id',$request->phase_id);
        // }])->get();


        //Show only Products which have items

        $items =Product::withWhereHas('items',function ($query) use ($request){
            $query->where('site',2)->where('project_phase_id',$request->phase_id);
        })->get();


        return ProductResource::collection($items);
    }

}
