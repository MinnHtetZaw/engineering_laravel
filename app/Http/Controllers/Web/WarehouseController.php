<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\WarehouseTransfer;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    //

    public function getList()
    {
        $data =  WarehouseTransfer::all();

        return $data;
    }

    public function generateWTO()
    {
          $data =  WarehouseTransfer::get()->last();

            if($data)
            {
                $wto = sprintf("%04s", ($data->id));
            }
            else{
                $wto = sprintf("%04s",1);
            }

        return response()->json($wto);
    }
}
