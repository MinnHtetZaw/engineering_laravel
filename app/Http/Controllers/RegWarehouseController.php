<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\RegionalWarehouse;
use App\Models\Item;
use App\Models\Product;

class RegWarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regionalwarehouses = RegionalWarehouse::all();
        return response()->json([
            'regionalwarehouses' => $regionalwarehouses
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $photoName = $request->warehouse_photo->getClientOriginalName();
        $photoPath = $request->file('warehouse_photo')->move(public_path('/warehouse_img'), $photoName);

        RegionalWarehouse::create([
            'warehouse_name' => $request->warehouse_name,
            'warehouse_photo' => $photoName,
            'region' => $request->region,
            'country' => $request->country,
            'location_address' => $request->location_address,
            'area' => $request->area,
            'capacity' => $request->capacity,
            'project_id' => $request->project_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => 'Regional Warehouse was saved!'
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

    public function regWarehouseProducts($id) {

        $items = Item::where('warehouse_id', $id)->get();

        $pdo = [];
        foreach($items as $item) {
            $product = Product::where('id', $item->product_id)->first();
            if (!in_array($product,$pdo)){
                array_push($pdo,$product);
            }

        }

        return response()->json([
            'products' => $pdo,
            'items' => $items,
        ],200);
    }
}
