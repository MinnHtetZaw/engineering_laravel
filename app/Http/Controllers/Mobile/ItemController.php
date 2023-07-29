<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SiteItemResource;
use Illuminate\Http\Request;

use App\Models\Item;
use App\Models\Product;

class ItemController extends Controller
{

    public function SiteItemsInventory()
    {

        $items =Product::with(['items'=>function ($query){
            $query->where('site',2)->get();
        }])->get();
        return ProductResource::collection($items);
    }

}
