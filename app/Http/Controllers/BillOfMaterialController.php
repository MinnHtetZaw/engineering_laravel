<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\BomSupplier;
use Illuminate\Http\Request;
use App\Mail\SendRequestMail;
use App\Models\BillOfMaterial;
use App\Models\BomProductLists;
use App\Models\BomSupplierProduct;
use App\Models\BomSupplierPoProduct;
use Illuminate\Support\Facades\Mail;
use App\Models\BomSupplierPurchaseOrder;
use App\Http\Requests\StoreBillOfMaterialRequest;
use App\Http\Requests\UpdateBillOfMaterialRequest;

class BillOfMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bom = BillOfMaterial::all();
        return response()->json([
            'bom' => $bom
        ],200);
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
     * @param  \App\Http\Requests\StoreBillOfMaterialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBillOfMaterialRequest $request)
    {
        //
        $bom = new BillOfMaterial();
        $bom->bom_no = $request->bom_no;
        $bom->project_id = $request->project_id;
        $bom->num_product_qty = $request->total_qty;
        $bom->date = $request->date;
        $bom->save();

        foreach($request->products as $product){
            $bom_product = new BomProductLists();
            $bom_product->bom_id = $bom->id;
            $bom_product->product_id = $product['product_id'];
            $bom_product->required_qty = $product['req_qty'];
            $bom_product->required_spec = $product['req_spec'];
            $bom_product->selected_supplier_id = $product['supplier_id'];
            $bom_product->save();
        }

        return response()->json([
            'data' => 'successfully stored!'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BillOfMaterial  $billOfMaterial
     * @return \Illuminate\Http\Response
     */
    public function show(BillOfMaterial $billOfMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BillOfMaterial  $billOfMaterial
     * @return \Illuminate\Http\Response
     */
    public function edit(BillOfMaterial $billOfMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBillOfMaterialRequest  $request
     * @param  \App\Models\BillOfMaterial  $billOfMaterial
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBillOfMaterialRequest $request, BillOfMaterial $billOfMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BillOfMaterial  $billOfMaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(BillOfMaterial $billOfMaterial)
    {
        //
    }


    // public function getBom($id){

    //     $bom= BillOfMaterial::find($id);


    //     return response()->json(['bom'=>$bom]);
    // }

    public function supplierproduct($bid,$sid){
        $products = BomProductLists::where('bom_id',$bid)->where('selected_supplier_id',$sid)->get();
        $email = Supplier::where('id',$sid)->first();
        return response()->json([
            'products' => $products,
            'email' => $email->email,
        ]);
    }
    public function bomproduct($id){
        $products = BomProductLists::where('bom_id',$id)->whereNot('selected_supplier_id',null)->get();
        $suppliers = [];
        foreach($products as $pro){
        if($pro->selected_supplier_id !=null ){
            $sup = Supplier::where('id',$pro->selected_supplier_id)->first();
            array_push($suppliers,$sup);
        }
        }
        return response()->json([
            'products' => $products,
            'suppliers' => $suppliers,
        ]);
    }

    public function bomproductid(Request $request){
        if($request->type == 1){
            $products = BomProductLists::where('id',$request->id)->first();
            $products->required_price = $request->price;
            $products->save();
        }
        if($request->type == 2){
            $product = BomSupplierProduct::where('id',$request->id)->first();
            $bomsupplier = BomSupplier::find($product->bom_supplier_id);

            $bomproductlist =BomProductLists::where('bom_id',$bomsupplier->bom_id)->where('product_id',$product->product_id)->first();
            $bomproductlist->required_price = $request->price;
            $bomproductlist->save();

        }

        return response()->json([
            'data' => $products
        ],200);
    }

    public function bomproductqty(Request $request){
        if($request->type == 1){
            $products = BomProductLists::where('id',$request->id)->first();
            $products->required_qty = $request->qty;
            $products->save();
        }

        if($request->type == 2){
            $product = BomSupplierProduct::where('id',$request->id)->first();
            $bomsupplier = BomSupplier::find($product->bom_supplier_id);

            $bomproductlist =BomProductLists::where('bom_id',$bomsupplier->bom_id)->where('product_id',$product->product_id)->first();

            $bom=BillOfMaterial::find($bomsupplier->bom_id);

           if($bomproductlist->required_qty < $request->qty ){
            $bom->num_product_qty += $request->qty - $bomproductlist->required_qty;

           }elseif($bomproductlist->required_qty > $request->qty){
            $bom->num_product_qty -=   $bomproductlist->required_qty - $request->qty;
           }
           $bom->save();

           $bomproductlist->required_qty = $request->qty;
            $bomproductlist->save();
        }

        return response()->json(   $bom->num_product_qty);
    }

    public function bomproductspec(Request $request){
        if($request->type == 1){
            $products = BomProductLists::where('id',$request->id)->first();
            $products->required_spec = $request->spec;
            $products->save();
            }
            if($request->type == 2){
                $products = BomSupplierProduct::where('id',$request->id)->first();
                $products->requested_specs = $request->spec;
                $products->save();
            }

            return response()->json([
                'data' => $products
            ],200);
    }

    public function bomproductviewspec(Request $request){
        $products = BomProductLists::where('id',$request->id)->first();
        $products->save();

        return response()->json([
            'data' => $products->required_spec
        ],200);
    }

    public function request_mail(Request $request){

        if($request->edit == 1){
            $bomsupplier = BomSupplier::find($request->bom_sup_id);
            $bomsupplier->po_sent_date = $request->date;
            $bomsupplier->save();

            $newName='purchaseorder_'.uniqid().".".$request->file('file')->extension();
            $request->file('file')->move(public_path() . '/purchaseorder/', $newName);

        $bomsupplierpo = new BomSupplierPurchaseOrder();
        $bomsupplierpo->bom_supplier_id = $request->bom_sup_id;
        $bomsupplierpo->supplier_po_no = $request->pono;
        $bomsupplierpo->po_email_title = $request->title;
        $bomsupplierpo->po_email_description = $request->body;
        $bomsupplierpo->po_email_filepath = $newName;
        $bomsupplierpo->po_date = $request->date;
        $bomsupplierpo->status = 0;
        $bomsupplierpo->save();

            return response()->json(["data" => 'Successfully Stored!'],200);
        }

        if($request->edit == 2){
            if($request->file('file') != null){
                $newName='purchaseorder_'.uniqid().".".$request->file('file')->extension();
                $request->file('file')->move(public_path() . '/purchaseorder/', $newName);

        $bomsupplierpo = BomSupplierPurchaseOrder::where('bom_supplier_id',$request->bom_sup_id)->first();
        $bomsupplierpo->po_email_filepath = $newName;
        $bomsupplierpo->save();
            }

        $bomsupplierpo = BomSupplierPurchaseOrder::where('bom_supplier_id',$request->bom_sup_id)->first();
        $bomsupplierpo->supplier_po_no = $request->pono;
        $bomsupplierpo->po_email_title = $request->title;
        $bomsupplierpo->po_email_description = $request->body;
        $bomsupplierpo->po_date = $request->date;
        $bomsupplierpo->status = 0;
        $bomsupplierpo->save();

            return response()->json(["data" => 'Successfully Updated!'],200);
        }
        // Mail::to('maymyatmoe211099@gmail.com')->send(new SendRequestMail($request->title,$request->body,$request->products));

    }

    public function test(Request $request){

        if($request->type == 2){
            Mail::to('minnhtetzaw.dev@gmail.com')->send(new SendRequestMail($request->title,$request->body,$request->test,$request->type));
        }

        if($request->edit == 1){
            $totqty = 0; $totamount = 0;
        $bspo = BomSupplierPurchaseOrder::where('bom_supplier_id',$request->bsi)->where('supplier_po_no',$request->pn)->first();
        foreach($request->test as $product){
             $totamount += $product['requested_qty'] * $product['requested_price'];
             $totqty += $product['requested_qty'];
            $bomsupplierproduct = new BomSupplierPoProduct();
            $bomsupplierproduct->bom_po_id = $bspo->id;
            $bomsupplierproduct->product_id = $product['product_id'];
            $bomsupplierproduct->order_qty = $product['requested_qty'];
            $bomsupplierproduct->order_price = $product['requested_price'];
            $bomsupplierproduct->required_specification = $product['requested_specs'];
            $bomsupplierproduct->save();
        }
        $bspo->po_total_qty = $totqty;
        $bspo->po_total_price = $totamount;
        $bspo->save();

        return response()->json(["data" => 'Email Sent!'],200);
        }


        if($request->edit == 2){
            $totqty = 0; $totamount = 0;
            $bspo = BomSupplierPurchaseOrder::where('bom_supplier_id',$request->bsi)->where('supplier_po_no',$request->pn)->first();
            foreach($request->test as $product){
                 $totamount += $product['requested_qty'] * $product['requested_price'];
                 $totqty += $product['requested_qty'];
                $bomsupplierproduct = BomSupplierPoProduct::where('bom_po_id',$bspo->id)->where('product_id',$product['product_id'])->first();
                $bomsupplierproduct->order_qty = $product['requested_qty'];
                $bomsupplierproduct->order_price = $product['requested_price'];
                $bomsupplierproduct->required_specification = $product['requested_specs'];
                $bomsupplierproduct->save();
            }
            $bspo->po_total_qty = $totqty;
            $bspo->po_total_price = $totamount;
            $bspo->save();

            return response()->json(["data" => 'Email Sent!'],200);
        }

    }
}
