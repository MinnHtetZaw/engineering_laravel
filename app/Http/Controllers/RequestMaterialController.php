<?php

namespace App\Http\Controllers;

use App\Http\Resources\MaterialIssueResource;
use App\Http\Resources\RequestMaterialResource;
use App\Models\Item;
use App\Models\MaterialIssue;
use App\Models\MaterialIssueList;
use App\Models\RequestMaterial;
use App\Models\RequestMaterialList;
use Illuminate\Http\Request;

class RequestMaterialController extends Controller
{
    //
    public function storeRequestProduct(Request $request)
    {

        try{
            $rm =  RequestMaterial::get()->last();
            if($rm)
            {
             $rm_num =  "RM-" . sprintf("%02s", (intval(date('m')))) . sprintf("%03s", ($rm->id+1));
            }
            else{
             $rm_num =  "RM-" . sprintf("%02s", (intval(date('m')))) . sprintf("%03s", 1);
            }

            $data= RequestMaterial::create([

                'request_code'=> $rm_num,
                'employee_id'=>$request->employee_id,
                'project_id'=>$request->project_id,
                'project_phase_id'=>$request->phase_id,
                'request_date'=>$request->request_date,
                'reason'=>$request->reason,
                'requested_by'=>$request->requested_by
            ]);

            foreach($request->products as $product)
            {
                RequestMaterialList::create([
                    'request_material_id'=>$data->id,
                    'product_id'=>$product['product_id'],
                    'requested_quantity'=>$product['quantity'],
                    'approved_quantity'=>$product['quantity'],
                ]);
            }

            return new RequestMaterialResource($data);
        }
        catch(\Exception $e)
        {
            return $e;
        }

    }

    public function getRequestMaterialList()
    {
        return RequestMaterialResource::collection(RequestMaterial::all());
    }

    public function getRequestById($id)
    {
       $data =  RequestMaterial::find($id);
        return response()->json($data);
    }
    public function changeStatus(Request $request)
    {
        try {
            $data = RequestMaterial::findOrFail($request->request_id);
            $data->isApproved = $request->isApproved;
            $data->save();

        } catch (\Throwable $th) {
            return $th;
        }
        return response()->json($data);
    }

    public function showIssueList()
    {
        $data = MaterialIssue::all();

        return MaterialIssueResource::collection($data);


    }

    public function saveMaterialIssue($id)
    {
        $data  =  RequestMaterial::find($id);
        $data->isIssued = 1;
        $data->dispatch_date= date('Y-m-d');
        $data->save();

        $mi =  MaterialIssue::get()->last();
        if($mi)
        {
         $mi_num =  "MI-" . sprintf("%02s", (intval(date('m')))) . sprintf("%03s", ($mi->id+1));
        }
        else{
         $mi_num =  "MI-" . sprintf("%02s", (intval(date('m')))) . sprintf("%03s", 1);
        }

        try{

            $material_issue =  MaterialIssue::create([
                    'material_issue_no'=>$mi_num,
                    'project_id' => $data->project_id,
    			    'project_phase_id' => $data->project_phase_id,
                    'request_material_id'=>$data->id,
                    'total_qty'=>$data->products->sum('approved_quantity'),
                ]);


                foreach ( $data->products as $product_list) {

                    $items = collect($product_list->product->items->where('warehouse_type',1)->where('in_stock_flag',1))->values()  ;

                    for($i=0;   $i < $product_list->approved_quantity ; $i++ )
                    {
                         MaterialIssueList::create([
                        'material_issue_id' => $material_issue->id,
                        'item_id' => $items[$i]->id,
                        'issue_qty' => 1,
                    ]);
                        $item=Item::find($items[$i]->id);
                        $item->reserved_flag = 1;
                        $item->in_stock_flag = 0;
                        $item->save();
                    }

                }
            return response()->json(['success'=>"Successfully Issued!"]);
        }
        catch(\Throwable $th)
        {
            return $th;
        }
    }
}
