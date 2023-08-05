<?php

namespace App\Http\Controllers;

use App\Http\Resources\SaleOrderResource;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestList;
use App\Models\RegionalWarehouse;
use App\Models\SaleOrder;
use App\Models\SaleOrderList;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    //

    public function storeSaleOrder(Request $request)
    {
               $sale =  SaleOrder::get()->last();
               if($sale)
               {
                $sale_num =  "SO-" . sprintf("%02s", (intval(date('m')))) . sprintf("%03s", ($sale->id));
               }
               else{
                $sale_num =  "SO-" . sprintf("%02s", (intval(date('m')))) . sprintf("%03s", 1);
               }


            $sale_order= SaleOrder::create([
                'sale_order_no'=>$sale_num,
                'project_id'=>$request->project_id,
                'phase_id'=>$request->phase_id,
                'delivery_date'=>$request->delivery_date
            ]);

            foreach($request->products as $data)
            {
                    SaleOrderList::create([
                    'product_id'=>$data['product_id'],
                    'sale_order_id'=>$sale_order->id,
                    'qty'=>$data['qty']
                    ]);
            }

        return response()->json(['success'=>'Successfully Stored Sale Order']);

    }
    public function getSaleOrders()
    {
      $data = SaleOrder::all();

      return SaleOrderResource::collection($data);

    }

    public function purchaseRequest(Request $request)
    {

        $pr =  PurchaseRequest::get()->last();
        if($pr)
        {
         $pr_num =  "WPR-" . sprintf("%02s", (intval(date('m')))) . sprintf("%03s", ($pr->id));
        }
        else{
         $pr_num =  "WPR-" . sprintf("%02s", (intval(date('m')))) . sprintf("%03s", 1);
        }
        
        if($request->destination_regional_id){
            $regWh=  RegionalWarehouse::find($request->destination_regional_id);
            $regional_name=$regWh->warehouse_name;
        }else{
            $regional_name=null;
        }

        try{
            $purchaseRequest= PurchaseRequest::create([
                'pr_no'=>$pr_num,
                'request_date'=>$request->date,
                'project_id'=>$request->project_id,
                'project_phase_id'=>$request->phase_id,
                'request_material_id'=>$request->request_material_id,
                'destination_flag'=>$request->destination_flag,
                'destination_regional_id'=>$request->destination_regional_id,
                'regional_name'=>$regional_name
            ]);

            foreach($request->products as $product)
            {
                    PurchaseRequestList::create([
                        'purchase_request_id'=>$purchaseRequest->id,
                        'product_id'=>$product['product_id'],
                        'required_qty'=>$product['required_quantity'],
                    ]);
            }
        }
        catch(\Throwable $e){
            return $e;
        }

        return response()->json(['success'=>'Successfully Requested']);
    }
}
