<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller
{
    //
    public function getZone(){
        $zone = Zone::all();

    return response()->json(['zone'=>$zone]);

    }

    public function store_zone(Request $request){
        $validator = Validator::make($request->all(), [
            "zoneName" => "required",

        ]);
        if ($validator->fails()) {
            return $this->sendError('အချက်အလက် များ မှားယွင်း နေပါသည်။');
        }

        Zone::create([
            'name'=>$request->zoneName,
            'description'=>$request->zoneDescription
        ]);

        return response()->json(['success'=>"Successfully Created"],200);
    }
}
