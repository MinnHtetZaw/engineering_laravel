<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    //
    public function getPartall(){
        $parts = Part::all();

        return response()->json(['parts'=>$parts]);
    }

    public function storePart(Request $request){

        $part = new Part();
        $part->part_number=$request->part_number;
        $part->name = $request->name;
        $part->stock_qty=$request->qty;
        $part->reg_date =$request->date;
        $part->product_id = $request->product_id;
        $part->brand_name = $request->brand_name;
        $part->save();


        return response()->json(['success'=>'Successfully Added!']);
    }

    public function deletePart($id){

        Part::find($id)->destroy();

        return response()->json(['success'=>'Successfully Deleted!']);
    }

    public function editPart(Request $request,$id){

        $partDetail =Part::find($id);

        if($request->part_number !=null){

            $partDetail->part_number = $request->part_number;
            $partDetail->name=$request->name;
            $partDetail->brand_name=$request->brand_name;
            $partDetail->stock_qty=$request->qty;
            $partDetail->reg_date=$request->date;
            $partDetail->save();
        }

        return response()->json([
                'partDetail'=>$partDetail
            ]);

    }

}
