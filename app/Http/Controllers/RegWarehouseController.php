<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\RegionalWarehouse;
use App\Models\Item;
use App\Models\MaterialIssue;
use App\Models\Product;
use App\Models\Project;
use App\Models\ProjectPhase;

class RegWarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regionalwarehouses = RegionalWarehouse::with('project')->get();
        return response()->json([
            'regionalwarehouses' => $regionalwarehouses
        ],200);
    }


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

    public function projectFilter(Project $project)
    {
        return response()->json(['data'=>$project->phases]);
    }

    public function getIssueListByPhase(ProjectPhase $phase)
    {
        $data = MaterialIssue::whereProjectPhaseId($phase->id)->get();
        $contact_person = $phase->supervisor->name;

        return response()->json([
            'data'=>$data,
            'contact_person'=>$contact_person
          ]);
    }
}
