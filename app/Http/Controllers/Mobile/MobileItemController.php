<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Item;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\DeliveryOrder;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SiteItemResource;
use App\Http\Resources\DeliveryOrderResource;
use App\Models\Employee;

class MobileItemController extends Controller
{

    public function getProductList()
    {
       $data= Product::select('id as product_id','product_name','product_img')->without('category','brand','subcategory','primarysupplier')->get();

       return response()->json(['products'=>$data]);
    }

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


    public function siteDeliveryOrder(Employee $employee)
    {

    	$site_delivery_orders = DeliveryOrder::whereHas('phase',function ($query) use ($employee){
                                               return $query->where('user_id',$employee->user_id);
                            })->get();

    	return DeliveryOrderResource::collection($site_delivery_orders);

    }

    public function receiveOrder(Request $request)
    {

        $DO = DeliveryOrder::find($request->delivery_order_id);
        $DO->receive_status = 1 ;
        $DO->save();

        foreach ($DO->deliveryOrderList as $list)
        {
            $item = Item::find($list->item_id);
            $item->in_stock_flag = 1;
            $item->reserved_flag = 0;
            $item->in_transit_flag = 0;
            $item->delivered_flag = 0;
            $item->active_flag = 0;
            $item->site_direct_flag = 0;

            $item->project_id = $DO->project_id;
            $item->project_phase_id = $DO->project_phase_id;
            $item->site = 2;
            $item->warehouse_type = 0;
            $item->warehouse_id = 0 ;
            $item->save();

        }

        $site_delivery_orders = DeliveryOrder::all();

    	return DeliveryOrderResource::collection($site_delivery_orders);

    }

}
