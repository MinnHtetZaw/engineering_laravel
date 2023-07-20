<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Resources\SiteItemResource;
use Illuminate\Http\Request;

use App\Models\Item;
use App\Models\Product;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::where('warehouse_type', 1)->get();
        return response()->json([
            'items' => $items,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Item::create([
            'product_id' => $request->product_id,
            'warehouse_type' => $request->warehouse_type,
            'warehouse_id' => $request->warehouse_id,
            'site' => $request->site,
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function SiteItems()
    {
        $sitems = Item::where('site', 2)->get();
        return response()->json([
            'sitems' => $sitems,
        ], 200);
    }

    public function SiteItemsInventory()
    {

        $items =Product::with(['items'=>function ($query){
            $query->where('site',2)->get();
        }])->get();
        return ProductResource::collection($items);
    }

}
