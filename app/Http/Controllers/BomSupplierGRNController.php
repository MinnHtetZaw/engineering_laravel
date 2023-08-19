<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\BomSupplier;
use Illuminate\Http\Request;
use App\Models\BomSupplierGrn;


class BomSupplierGRNController extends Controller
{
    //

    public function saveGRNData(Request $request){

        try{
            $bom_supplier = BomSupplier::find($request->bom_supplier_id);
            if( empty($bom_supplier->GRN_date) ){

                $bom_supplier->GRN_date = $request->grnDate;
                $bom_supplier->save();
            }

           $bomGRN = BomSupplierGrn::create([
            'grn_no'=>$request->grnNo,
            'grnDate'=>$request->grnDate,
            'bom_sup_po_id'=>$request->po_id,
            'arrived_qty'=>$request->grnTotal??0,
            'po_total_qty'=>$request->po_qty,
            'recevied_by'=>$request->receive,
            'delivered_by'=>$request->deliver,
            ]);
            return response()->json(['success'=>'Successfully Stored GRN']);
        }
        catch(\Exception $e)
        {
            return $e;
        }


    }

    public function saveGRNItem(Request $request){

        $GRN = BomSupplierGrn::find($request->grn_id);

            $item=Item::create([
            'product_id' => $request->product_id,
            'warehouse_type' => $request->warehouse_type,
            'warehouse_id' =>$request->warehouse_id,
            'site' =>$request->site,
            'serial_no' =>$request->serial_no,
            'model' =>$request->model,
            'size' =>$request->size,
            'color' =>$request->color,
            'dimension' =>$request->dimension,
            'hs_code' =>$request->hs_code,
            'other_specification' =>$request->other_specification,
            'reserved_flag' =>$request->reserved_flag,
            'in_transit_flag' =>$request->in_transit_flag,
            'in_stock_flag' =>$request->in_stock_flag,
            'delivered_flag' =>$request->delivered_flag,
            'active_flag' =>$request->active_flag,
            'site_direct_flag' =>$request->site_direct_flag,
            'condition_type' =>$request->condition_type,
            'condition_remark' =>$request->condition_remark,
            'damage_remark' =>$request->damage_remark,
            'unit_purchase_price' =>$request->unit_purchase_price,
            'unit_selling_price' =>$request->unit_selling_price,
            'currency_type_id' =>$request->currency_type_id,
            'supplier_id' =>$request->supplier_id,
            'purchase_date' =>$request->purchase_date,
            'delivered_date' =>$request->delivered_date,
            'registered_date' =>$request->registered_date,
            'stock_qty' =>$request->stock_qty,
            'level_id' =>$request->level_id,
            'grn_flag'=>$request->grn_flag
        ]);

        $GRN->item()->attach($item);

        $GRN->arrived_qty +=1;
        $GRN->save();

        return response()->json(['success'=>'Successfully Stored GRN Item']);
    }

}
