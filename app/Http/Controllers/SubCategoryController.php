<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
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
        return response()->json([
            'categories' => $categories,
            'subcategories' => $subcategories
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
            'category_id' => 'required',
            'subcategory_code' => 'required',
            'subcategory_name' => 'required'
        ]);
        SubCategory::create([
            'category_id' => $request->category_id,
            'subcategory_code' => $request->subcategory_code,
            'subcategory_name' => $request->subcategory_name
        ]);
        return response()->json([
            'success' => 'Sub Category was saved!'
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
        $subcategory = SubCategory::whereId($id)->first();
        return response()->json([
            'subcategory' => $subcategory
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
            'category_id' => 'required',
            'subcategory_code' => 'required',
            'subcategory_name' => 'required'
        ]);
        SubCategory::where('id', $id)->update([
            'category_id' => $request->category_id,
            'subcategory_code' => $request->subcategory_code,
            'subcategory_name' => $request->subcategory_name,
        ]);
        return response()->json([
            'success' => 'Sub Category was updated!'
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
        SubCategory::where('id', $id)->delete();
        return response()->json([
            'success'=>'Sub Category was deleted!'
        ], 200);
    }
}
