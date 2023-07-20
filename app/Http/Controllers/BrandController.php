<?php

namespace App\Http\Controllers;

use App\Models\Brand;

use App\Models\Category;
use App\Models\Supplier;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $suppliers = Supplier::all();
        $brands = Brand::all();

        return response()->json([
            'categories' => $categories,
            'subcategories' => $subcategories,
            'suppliers' => $suppliers,
            'brands' => $brands,

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
            'brand_code' => 'required',
            'brand_name' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'description' => 'required',
            'supplier_id' => 'required',
            'country_of_origin' => 'required'
        ]);
        Brand::create([
            'brand_code' => $request->brand_code,
            'brand_name' => $request->brand_name,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'description' => $request->description,
            'supplier_id' => $request->supplier_id,
            'country_of_origin' => $request->country_of_origin
        ]);
        return response()->json([
            'success' => 'Brand was saved!'
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
        $brand = Brand::whereId($id)->first();
        return response()->json([
            'brand' => $brand
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
            'brand_code' => 'required',
            'brand_name' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'description' => 'required',
            'suppliers' => 'required',
            'country_of_origin' => 'required'
        ]);
        Brand::where('id', $id)->update([
            'brand_code' => $request->brand_code,
            'brand_name' => $request->brand_name,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'description' => $request->description,
            'suppliers' => $request->suppliers,
            'country_of_origin' => $request->country_of_origin
        ]);
        return response()->json([
            'success' => 'Brand was updated!'
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
        Brand::where('id', $id)->delete();
        return response()->json([
            'success'=>'Brand was deleted!'
        ], 200);
    }
}
