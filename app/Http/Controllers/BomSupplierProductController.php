<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\BomSupplier;
use App\Models\BomSupplierProduct;
use App\Models\BomSupplierPurchaseOrder;
use App\Http\Requests\StoreBomSupplierProductRequest;
use App\Http\Requests\UpdateBomSupplierProductRequest;
use App\Models\BillOfMaterial;
use App\Models\BomProductLists;
use App\Models\BomSupplierGrn;

class BomSupplierProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBomSupplierProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBomSupplierProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BomSupplierProduct  $bomSupplierProduct
     * @return \Illuminate\Http\Response
     */
    public function show(BomSupplierProduct $bomSupplierProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BomSupplierProduct  $bomSupplierProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(BomSupplierProduct $bomSupplierProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBomSupplierProductRequest  $request
     * @param  \App\Models\BomSupplierProduct  $bomSupplierProduct
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBomSupplierProductRequest $request, BomSupplierProduct $bomSupplierProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BomSupplierProduct  $bomSupplierProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(BomSupplierProduct $bomSupplierProduct)
    {
        //
    }

    public function getBomSupplierProductData($id){



        $bom_supplier = BomSupplier::find($id);

        $bomData=   BillOfMaterial::find($bom_supplier->bom_id);

        $products = BomSupplierProduct::where('bom_supplier_id',$bom_supplier->id)->get();

        $bomproducts = BomProductLists::where('bom_id',$bom_supplier->bom_id)->where('product_id',$products->pluck('product_id'))->first();

        $view = BomSupplierPurchaseOrder::where('bom_supplier_id',$id)->first();

        $grnNo=BomSupplierGrn::all()->last();

        if( $grnNo != null){
            $grnID = "GRN-" .date('y') . sprintf("%02s", (intval(date('m')) + 1)) .sprintf("%03s", ( $grnNo->id+1));
        }else{
            $grnID = "GRN-" .date('y') . sprintf("%02s", (intval(date('m')) + 1)) .sprintf("%03s", 1);
        }

        if( $view !=null ){
            $existGRNData=BomSupplierGrn::where('bom_sup_po_id',$view->id)->with('item')->first();
        }else{
            $existGRNData=null;
        }


        return response()->json([
            'bomproducts'=>$bomproducts,
            'products' => $products,
            'suppliername' => $bom_supplier->supplier->name,
            'supplieremail' => $bom_supplier->supplier->email,
            'view' => $view,
            'bomData'=> $bomData,
            'existGRNData'=>$existGRNData,
            'grnNo'=>$grnID
        ]);

    }
}
