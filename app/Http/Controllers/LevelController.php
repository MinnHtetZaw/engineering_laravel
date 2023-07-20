<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    //
    public function getLevel(){
        $level = Level::all();

        return response()->json(['level'=>$level]);
    }

    public function storeLevel(Request $request){

        Level::create([
            'level_code'=>$request->level_code,
            'level_name'=>$request->level_name,
            'level_description'=>$request->level_description,
            'zone_id'=>$request->zone_id,
            'shelf_id'=>$request->shelf_id,
        ]);

        return response()->json(['success'=>"Successfully Created"],200);
    }
}
