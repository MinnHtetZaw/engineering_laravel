<?php

namespace App\Http\Controllers;

use App\Models\BomSupplier;
use App\Mail\SendRequestMail;
use App\Models\BomSupplierProduct;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreBomSupplierRequest;
use App\Http\Requests\UpdateBomSupplierRequest;

class BomSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bomsupplier = BomSupplier::all();
        return response()->json([
            'bomsupplier' => $bomsupplier
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
     * @param  \App\Http\Requests\StoreBomSupplierRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBomSupplierRequest $request)
    {
        //

        $bomsupplier = new BomSupplier();
        $bomsupplier->request_no = $request->req_no;
        $bomsupplier->bom_id = $request->bom_id;
        $bomsupplier->supplier_id = $request->supplier_id;
        $bomsupplier->request_quotation_date = $request->date;
        $bomsupplier->status = 1;
        $bomsupplier->save();

        foreach($request->products as $product){
            $bomsupplierproduct = new BomSupplierProduct();
            $bomsupplierproduct->bom_supplier_id = $bomsupplier->id;
            $bomsupplierproduct->product_id = $product['product_id'];
            $bomsupplierproduct->requested_qty = $product['required_qty'];
            $bomsupplierproduct->requested_price = $product['required_price'];
            $bomsupplierproduct->requested_specs = $product['required_spec'];
            $bomsupplierproduct->status = 1;
            $bomsupplierproduct->save();
        }

        if($request->type == 4){
            Mail::to('maymyatmoe211099@gmail.com')->send(new SendRequestMail($request->title,$request->body,$request->products,$request->type));
        }

        return response()->json([
            'data' => 'successfully stored!'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BomSupplier  $bomSupplier
     * @return \Illuminate\Http\Response
     */
    public function show(BomSupplier $bomSupplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BomSupplier  $bomSupplier
     * @return \Illuminate\Http\Response
     */
    public function edit(BomSupplier $bomSupplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBomSupplierRequest  $request
     * @param  \App\Models\BomSupplier  $bomSupplier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBomSupplierRequest $request, BomSupplier $bomSupplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BomSupplier  $bomSupplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(BomSupplier $bomSupplier)
    {
        //
    }

    public function BomSupplierFilter($id){
       $bomsupplier =BomSupplier::where('bom_id',$id)->get();
       return response()->json([
        'bomsupplier'=>$bomsupplier
       ]);
    }
}
