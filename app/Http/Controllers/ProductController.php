<?php

namespace App\Http\Controllers;

use App\Models\Item;

use App\Models\Zone;
use App\Models\Brand;
use App\Models\Level;
use App\Models\Shelf;
use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Supplier;
use App\Models\Department;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\RegionalWarehouse;
use App\Models\SupplierProductComparison;

class ProductController extends Controller
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
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $departments = Department::all();
        $currencies = Currency::all();
        $zone=Zone::all();
        $shelf=Shelf::all();
        $level=Level::all();


        $pro_ids = Item::where('warehouse_type', 1)->get();
        $pdo = [];
        foreach($pro_ids as $pro_id) {
            $products = Product::where('id', $pro_id->product_id)->first();
            array_push($pdo,$products);
        }

        $regwarehouses = RegionalWarehouse::all();

        $productData = Product::all();

        return response()->json([
            'categories' => $categories,
            'subcategories' => $subcategories,
            'brands' => $brands,
            'suppliers' => $suppliers,
            // 'products' => $products,
            'departments' => $departments,
            'currencies' => $currencies,
            'products' => $pdo,
            'regwarehouses' => $regwarehouses,
            'zone'=>$zone,
            'shelf'=>$shelf,
            'level'=>$level,
            'productData'=>$productData
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

        $photoName = $request->product_img->getClientOriginalName();
        $photoPath = $request->file('product_img')->move(public_path('/product_img'), $photoName);

        $AddedProd = Product::create([
            'department' => $request->department,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'brand_id' => $request->brand_id,
            'product_name' => $request->product_name,
            'part_number' => $request->part_number,
            'measuring_unit' => $request->measuring_unit,
            'register_date' => $request->register_date,
            'description' => $request->description,
            'instock_order' => $request->instock_order,
            'min_order_quantity' => $request->min_order_quantity,
            'moq_price' => $request->moq_price,
            'instock_quantity' => $request->instock_quantity,
            'reorder_quantity' => $request->reorder_quantity,
            'primary_supplier_id' => $request->primary_supplier_id,
            'second_supplier_id' => $request->second_supplier_id,
            'product_img' => $photoName
        ]);

        if($AddedProd) {
            $product = Product::latest('register_date')->first('id');

            SupplierProductComparison::create([
                'supplier_id' => $request->primary_supplier_id,
                'product_id' => $product,
            ]);
        }

        return response()->json([
            'success' => 'Product was saved!'
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
        $product = Product::whereId($id)->first();
        return response()->json([
            'product' => $product
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
            'department' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'brand_id' => 'required',
            'product_name' => 'required',
            'part_number' => 'required',
            'measuring_unit' => 'required',
            'register_date' => 'required',
            'description' => 'required',
            'instock_order' => 'required',
            'min_order_quantity' => 'required',
            'moq_price' => 'required',
            'instock_quantity' => 'required',
            'reorder_quantity' => 'required',
            'primary_supplier' => 'required',
            'second_supplier' => 'required',
            'product_img' => 'required|image|mimes:jpg,png,jpeg,gif'
        ]);

        $imageName = $request->product_img->extension();
        $request->product_img->move(public_path('images'), $imageName);

        Product::where('id', $id)->update([
            'department' => $request->department,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'brand_id' => $request->brand_id,
            'product_name' => $request->product_name,
            'part_number' => $request->part_number,
            'measuring_unit' => $request->measuring_unit,
            'register_date' => $request->register_date,
            'description' => $request->description,
            'instock_order' => $request->instock_order,
            'min_order_quantity' => $request->min_order_quantity,
            'moq_price' => $request->moq_price,
            'instock_quantity' => $request->instock_quantity,
            'reorder_quantity' => $request->reorder_quantity,
            'primary_supplier' => $request->primary_supplier,
            'second_supplier' => $request->second_supplier,
            'product_img' => $imageName,
        ]);

        return response()->json([
            'success' => 'Product was saved!'
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
        Product::where('id', $id)->delete();
        return response()->json([
            'success'=>'Product was deleted!'
        ], 200);
    }

    public function department_filter(Request $request){
        $product = Product::where('department_id',$request->department_id)->get();
        $category = [];
        foreach($product as $pro){
            $cat = Category::where('id',$pro->category_id)->first();
            array_push($category,$cat);
        }

        $category = collect($category)->unique();

        return response()->json([
            'products' => $product,
            'categories' => $category,
        ]);
    }

    public function category_filter(Request $request){
        $product = Product::where('department_id',$request->department_id)->where('category_id',$request->category_id)->get();
        $subcategory = [];
        foreach($product as $pro){
            $subcat = SubCategory::where('id',$pro->subcategory_id)->first();
            array_push($subcategory,$subcat);
        }
        $subcategory = collect($subcategory)->unique();
        return response()->json([
            'products' => $product,
            'subcategories' => $subcategory,
        ]);
    }

    public function subcategory_filter(Request $request){
        $product = Product::where('department_id',$request->department_id)->where('category_id',$request->category_id)->where('subcategory_id',$request->subcategory_id)->get();
        $brand = [];
        foreach($product as $pro){
            $bra = Brand::where('id',$pro->brand_id)->first();
            array_push($brand,$bra);
        }
        $brand = collect($brand)->unique();
        return response()->json([
            'products' => $product,
            'brands'  => $brand,
        ]);
    }

    public function brand_filter(Request $request){
        $product = Product::where('department_id',$request->department_id)->where('category_id',$request->category_id)->where('subcategory_id',$request->subcategory_id)->where('brand_id',$request->brand_id)->get();
        return response()->json([
            'products' => $product
        ]);
    }

    public function ProDetail($id) {
        $product = Product::whereId($id)->first();
        return response()->json([
            'product' => $product
        ], 200);
    }

    public function Compare($id) {
        $product = Product::first();

        $primary_id = $product->primary_supplier_id;
        $primary =Supplier::where('id', $primary_id)->first();
        $second_id = $product->second_supplier_id;
        $secondary =Supplier::where('id', $second_id)->first();

        $item = Item::where('product_id', $id)->first();

        return response()->json([
            'product' => $product,
            'primary' => $primary,
            'secondary' => $secondary,
            'item' => $item
        ], 200);
    }

    public function getProductList()
    {
       $data= Product::select('id as product_id','product_name','product_img')->without('category','brand','subcategory','primarysupplier')->get();

       return response()->json(['products'=>$data]);
    }

    public function displayProduct ()
    {
        $data= Product::with(
            ['category'=>function($query){$query->select('id','category_name');} ,
            'brand'=>function($query){$query->select('id','brand_name');} ,
            'subcategory'=>function($query){$query->select('id','subcategory_name');} ],
            )->without('primarysupplier')->get();

        return response()->json(['products'=>$data]);

    }

}

// phyo
