<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    //
    public function getAsset(){

        $assetData=Asset::with('room')->get();

        return response()->json(['assetData' =>$assetData]);

    }

    public function searchAsset()
    {
        $data = Asset::select('id','name','code')->get();

        return response()->json(['data'=>$data]);
    }

    public function storeAsset(Request $request){

        $assetName='Asset_'.uniqid().".".$request->file('file')->extension();
        $request->file('file')->move(public_path() . '/asset/', $assetName);



        $asset = new Asset();
        $asset->name = $request->name;
		$asset->code = $request->code;
        $asset->type = $request->type;
        $asset->room_id=$request->room_id;
		$asset->purchase_date = $request->purchaseDate;
		$asset->price = $request->price;
		$asset->salvage_price =  $request->salvagePrice;
        $asset->use_life = $request->use_life;
		$asset->yearly_depriciation = $request->yearDepriciation;
        $asset->warranty = $request->warranty;
		$asset->warranty_docs = $assetName;

        $asset->save();

        return response()->json(['success'=>'Successfully Added!']);
    }

    public function getAssetDetail($id){

        $assetData=Asset::find($id);

        return response()->json(['assetData'=>$assetData]);
    }
}
