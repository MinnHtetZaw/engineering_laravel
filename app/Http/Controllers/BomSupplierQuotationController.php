<?php

namespace App\Http\Controllers;

use App\Models\BomSupplier;
use Illuminate\Http\Request;
use App\Models\BomSupplierQuotation;
use App\Http\Requests\StoreBomSupplierQuotationRequest;
use App\Http\Requests\UpdateBomSupplierQuotationRequest;

class BomSupplierQuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bomsupplierquo = BomSupplierQuotation::all();
        return response()->json([
            'bomsupquo' => $bomsupplierquo
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
     * @param  \App\Http\Requests\StoreBomSupplierQuotationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBomSupplierQuotationRequest $request)
    {
        //
        $newName='quotation_'.uniqid().".".$request->file('file')->extension();
        $request->file('file')->move(public_path() . '/quotation/', $newName);

        $bom_supplier = BomSupplier::find($request->bom_supplier_id);
        $bom_supplier->quotation_reply_date = $request->date;
        $bom_supplier->save();
		// $bom_supplier_quo = BomSupplierQuotation::create([
		//
		// ]);
        $bomsupquo = new BomSupplierQuotation();
        $bomsupquo->bom_supplier_id = $request->bom_supplier_id;
		$bomsupquo->supplier_quotation_number = $request->quono;
        $bomsupquo->quotation_date = $request->date;
		$bomsupquo->quotation_file_name = $request->filename;
		$bomsupquo->quotation_file_description = $request->description;
		$bomsupquo->quotation_file_path = $newName;
        $bomsupquo->save();

        return response()->json([
            'data' => $bomsupquo
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BomSupplierQuotation  $bomSupplierQuotation
     * @return \Illuminate\Http\Response
     */
    public function show(BomSupplierQuotation $bomSupplierQuotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BomSupplierQuotation  $bomSupplierQuotation
     * @return \Illuminate\Http\Response
     */
    public function edit(BomSupplierQuotation $bomSupplierQuotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBomSupplierQuotationRequest  $request
     * @param  \App\Models\BomSupplierQuotation  $bomSupplierQuotation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBomSupplierQuotationRequest $request, BomSupplierQuotation $bomSupplierQuotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BomSupplierQuotation  $bomSupplierQuotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(BomSupplierQuotation $bomSupplierQuotation)
    {
        //
    }

    public function detail(Request $request){
        $bomsupquo = BomSupplierQuotation::where('bom_supplier_id',$request->id)->first();
        return response()->json([
            'bomsupquo' => $bomsupquo->quotation_file_path,
            'bomsupquoname' => $bomsupquo->quotation_file_name,
            'bomsupquodescription' => $bomsupquo->quotation_file_description
        ],200);
    }
}
