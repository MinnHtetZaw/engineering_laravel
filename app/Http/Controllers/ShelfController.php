<?php

namespace App\Http\Controllers;

use App\Models\Shelf;
use Illuminate\Http\Request;

class ShelfController extends Controller
{
    //
    public function getShelf(){
        $shelf = Shelf::all();

        return response()->json(['shelf'=>$shelf]);
    }

    public function storeShelf(Request $request){

        Shelf::create([
            'shelf_name'=>$request->shelfName,
            'zone_id'=>$request->zone_id,
            'shelf_description'=>$request->shelfDescription
        ]);

        return response()->json(['success'=>"Successfully Created"],200);

        return response()->json(['data'=>$request]);
    }
}
