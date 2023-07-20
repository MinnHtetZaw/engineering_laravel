<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Item;
use App\Models\Product;
use App\Models\Incoterm;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\SupplierProductComparison;

class AdminController extends Controller
{
    //
    public function getIncotermList(){
        $incoterms = Incoterm::all();
        return response()->json([
            'data'=>$incoterms
        ]);
    }

    public function getNewProductId(){
        $product = Product::all()->last();
        if(!$product){
            $productid= 1;
        }else{
            $productid= $product->id+1;
        }

       return response()->json($productid);
    }

    public function saveSupplierData(Request $request){

        $save_Supplier_Data = new SupplierProductComparison();

        $save_Supplier_Data->supplier_id = $request->supplier_id;
        $save_Supplier_Data->product_id = $request->product_id;
        $save_Supplier_Data->primary_flag = $request->primary_flag;
        $save_Supplier_Data->unit_purchase_price = $request->unitPurchasePrice;
        $save_Supplier_Data->currency_id = $request->currencyData;
        $save_Supplier_Data->incoterm_id = $request->incotermData;
        $save_Supplier_Data->last_purchase_date = $request->lastPurchaseDate;
        $save_Supplier_Data->initial_purchase_qty= $request->initialPurchaseQty;
        $save_Supplier_Data->initial_purchase_price = $request->initialPurchaseAmount;
        $save_Supplier_Data->delivery_leadtime = $request->deliveryLeadTime;
        $save_Supplier_Data->leadtime_type = $request->leadTimeType;
        $save_Supplier_Data->moq_qty = $request->minOrderQty;
        $save_Supplier_Data->moq_price = $request->minOrderQtyPrice;

        if ($request->discountStatus == true){
            $save_Supplier_Data->discount_type = $request->discountType;
            $save_Supplier_Data->discount_value = $request->discountAmount;
            $save_Supplier_Data->discount_condition = $request->discountCondition;
            $save_Supplier_Data->discount_condition_type = $request->discountConditionType;

        }
        if($request->creditStatus == true){
            $save_Supplier_Data->credit_term = $request->creditTerm;
            $save_Supplier_Data->credit_term_type = $request->creditTermType;
            $save_Supplier_Data->credit_condition =$request->creditCondition;
            $save_Supplier_Data->credit_condition_type = $request->creditConditionType;
            $save_Supplier_Data->credit_amount = $request->creditAmount;
        }
        $save_Supplier_Data->save();

        return response()->json(['success'=>'success']);
            // return response()->json($request);
    }

    public function storeProductData(Request $request){

        $secondary =json_decode($request->second_supplier_id);
        $secondary_id=[];
        foreach($secondary as $secondary_data){
            array_push($secondary_id,$secondary_data->value);
        }
        $secondaryID=json_encode($secondary_id);
        $new_product= new Product();
        $new_product->department_id = $request->department_id;
        $new_product->category_id = $request->category_id;
        $new_product->subcategory_id = $request->subcategory_id;
        $new_product->brand_id = $request->brand_id;
        $new_product->product_name = $request->product_name;
        $new_product->part_number = $request->part_number;
        $new_product->measuring_unit = $request->measuring_unit;
        $new_product->register_date = $request->register_date;
        $new_product->description = $request->description;
        $new_product->instock_order_type = $request->instock_order_type;
        $new_product->min_order_quantity = $request->min_order_quantity;
        $new_product->moq_price = $request->moq_price;
        $new_product->instock_quantity = $request->instock_quantity;
        $new_product->reorder_quantity = $request->reorder_quantity;
        $new_product->primary_supplier_id = $request->primary_supplier_id;
        $new_product->second_supplier_id =$secondaryID;

        if($request->has('product_img')) {
            $image=$request->file('product_img');
            $filename = $image->getClientOriginalName();
            $image->move(public_path().'/images/', $filename);
            $new_product->product_img=$filename;
        }
        $new_product->save();
        return response()->json( ['success'=>'Success']);

    }

    public function getProductDetail($id){
        $product_detail = Product::find($id);

        $second_id =json_decode($product_detail->second_supplier_id);
       $second_data = Supplier::whereIn('id',$second_id)->get();
        $product_detail->secondary_supplier=$second_data;
        return response()->json($product_detail);
    }

    public function getProductCompareData($id){
        $primaryData = SupplierProductComparison::where('product_id',$id)->where('primary_flag',1)->get();
        $secondaryData =SupplierProductComparison::where('product_id',$id)->where('primary_flag',2)->get();

        return response()->json([
            'primaryData'=>$primaryData,
            'secondaryData'=>$secondaryData
        ]);
    }

    public function getItemDetail($id){
        $item =Item::find($id);

        return response()->json($item);
    }

    public function getDepartmentList(){
        $department =Department::all();

        return response()->json($department);
    }


}
