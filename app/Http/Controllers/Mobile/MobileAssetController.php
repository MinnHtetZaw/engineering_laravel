<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;

class MobileAssetController extends Controller
{
    //
    public function searchAsset()
    {
        $data = Asset::select('id','name','code')->get();

        return response()->json(['data'=>$data]);
    }

    public function getAsset(){

        $assetData=Asset::with('room')->get();

        return response()->json(['assetData' =>$assetData]);

    }
}
