<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Resources\SiteItemResource;
use Illuminate\Http\Request;

use App\Models\Item;
use App\Models\Product;

class ItemController extends Controller
{

    public function index()
    {
        $items = Item::where('warehouse_type', 1)->get();
        return response()->json([
            'items' => $items,
        ], 200);
    }

    public function store(Request $request)
    {
        Item::create([
            'product_id' => $request->product_id,
            'warehouse_type' => $request->warehouse_type,
            'warehouse_id' => $request->warehouse_id,
            'site' => $request->site,
            'project_id'=>$request->project_id,
            'project_phase_id'=>$request->phase_id,
            'serial_no' => $request->serial_no,
            'model' => $request->model,
            'size' => $request->size,
            'color' => $request->color,
            'dimension' => $request->dimension,
            'hs_code' => $request->hs_code,
            'other_specification' => $request->other_specification,
            'reserved_flag' => $request->reserved_flag,
            'in_transit_flag' => $request->in_transit_flag,
            'in_stock_flag' => $request->in_stock_flag,
            'delivered_flag' => $request->delivered_flag,
            'active_flag' => $request->active_flag,
            'site_direct_flag' => $request->site_direct_flag,
            'condition_type' =>$request->condition_type,
            'condition_remark' => $request->condition_remark,
            'damage_remark' => $request->damage_remark,
            'unit_purchase_price' => $request->unit_purchase_price,
            'unit_selling_price' => $request->unit_selling_price,
            'currency_type_id' => $request->currency_type_id,
            'supplier_id' => $request->supplier_id,
            'purchase_date' => $request->purchase_date,
            'delivered_date' => $request->delivered_date,
            'registered_date' => $request->registered_date,
            'item_location' => $request->item_location,
            'stock_qty' => $request->stock_qty,
            'level_id' => $request->level_id,
            'grn_flag'=> $request->grn_flag
        ]);

        return response()->json([
            'success' => 'Item was saved!'
        ], 200);

    }

    public function SiteItems()
    {
        // $sitems = Product::where('site', 2)->get();

        $items =Product::withWhereHas('items',function ($query){
            $query->where('site',2);
        })->get();

        return ProductResource::collection($items);
    }

    public function SiteItemByPhase($id)
    {

        $items =Product::withWhereHas('items',function ($query) use ($id){
            $query->where('site',2)->where('project_phase_id',$id);
        })->get();

        return ProductResource::collection($items);
    }

}
