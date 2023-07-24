<?php

namespace App\Http\Controllers;

use App\Http\Resources\SaleOrderResource;
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
}
