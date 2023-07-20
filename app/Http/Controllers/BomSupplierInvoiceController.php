<?php

namespace App\Http\Controllers;

use App\Models\BomSupplier;
use Illuminate\Http\Request;
use App\Models\BomSupplierInvoice;

class BomSupplierInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bomsupplierinv = BomSupplierInvoice::all();
        return response()->json([
            'bomsupinv' => $bomsupplierinv
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $newName='invoice_'.uniqid().".".$request->file('file')->extension();
         $request->file('file')->move(public_path() . '/invoice/', $newName);

         $bom_supplier = BomSupplier::find($request->supplier_id);
         $bom_supplier->invoice_received_date = $request->date;
         $bom_supplier->save();
         // $bom_supplier_inv = BomSupplierQuotation::create([
         //
         // ]);
         $bomsupinv = new BomSupplierInvoice();
         $bomsupinv->bom_supplier_id = $request->supplier_id;
         $bomsupinv->supplier_invoice_number = $request->invno;
         $bomsupinv->invoice_date = $request->date;
         $bomsupinv->invoice_file_name = $request->filename;
         $bomsupinv->invoice_file_description = $request->description;
         $bomsupinv->invoice_file_path = $newName;
         $bomsupinv->save();

         return response()->json([
             'data' => $bomsupinv
         ],200);
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

    public function detail(Request $request){
        $bomsupinv = BomSupplierInvoice::where('bom_supplier_id',$request->id)->first();
        return response()->json([
            'bomsupinv' => $bomsupinv->invoice_file_path,
            'bomsupinvname' => $bomsupinv->invoice_file_name,
            'bomsupinvdescription' => $bomsupinv->invoice_file_description
        ],200);
    }
}
