<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Brand;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $brands = Brand::all();
        $suppliers = Supplier::all();
        return response()->json([
            'suppliers' => $suppliers
        ], 200);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'website' => 'required',
            // 'brand' => 'required',
            'social' => 'required',
            'department' => 'required',
            'address' => 'required',
            'country' => 'required',
            'sector' => 'required',
            'phone' => 'required',
            'fax' => 'required',
            'rank' => 'required',
            'remark' => 'required',
        ]);
        Supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'website' => $request->website,
            // 'brand' => $request->brand,
            'social' => $request->social,
            'department' => $request->department,
            'address' => $request->address,
            'country' => $request->country,
            'sector' => $request->sector,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'rank' => $request->rank,
            'remark' => $request->remark,
        ]);
        return response()->json([
            'success' => 'Supplier was saved!'
        ], 200);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::whereId($id)->first();
        return response()->json([
            'supplier' => $supplier
        ], 200);
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
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'website' => 'required',
            'brand' => 'required',
            'social' => 'required',
            'department' => 'required',
            'address' => 'required',
            'country' => 'required',
            'sector' => 'required',
            'phone' => 'required',
            'fax' => 'required',
            'rank' => 'required',
            'remark' => 'required',
        ]);
        Supplier::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'website' => $request->website,
            'brand' => $request->brand,
            'social' => $request->social,
            'department' => $request->department,
            'address' => $request->address,
            'country' => $request->country,
            'sector' => $request->sector,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'rank' => $request->rank,
            'remark' => $request->remark,
        ]);
        return response()->json([
            'success' => 'Supplier was updated!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Supplier::where('id', $id)->delete();
        return response()->json([
            'success'=>'Supplier was deleted!'
        ], 200);
    }
}
