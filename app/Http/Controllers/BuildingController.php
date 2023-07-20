<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Floor;
use App\Models\Building;
use App\Models\RoomType;
use App\Models\RoomTypes;
use App\Models\BuildingType;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    //
    public function getBuilding()
    {
        $buildings =  Building::with('floor', 'room')->get();

        return response()->json([
            'buildings' => $buildings
        ], 200);
    }

    public function storeBuilding(Request $request)
    {
        Building::create([
            'name' => $request->name,
            'number_per_floor' => $request->number
        ]);

        return response()->json([
            'success' => 'Successfully Stored Building!'
        ]);
    }

    public function getFloor()
    {
        $floor = Floor::all();

        return response()->json(['floor' => $floor]);
    }

    public function storeFloor(Request $request)
    {
        $floor = new Floor();
        $floor->floor_number = $request->number;
        $floor->building_id = $request->building_id;
        $floor->save();

        return response()->json(['success' => 'Successfully Stored Floor!']);
    }

    public function getRoomType(Request $request)
    {
        $roomtypes = RoomType::all();
        return response()->json(['roomtypes' => $roomtypes]);
    }

    public function getRoom(Request $request)
    {

        $room = Room::all();
        return response()->json(['room' => $room]);
    }

    public function storeRoom(Request $request)
    {

        $room_prefix = $request->room_prefix;

        $floor = Floor::where('building_id', $request->building_id)->first();

        $building = Building::find($request->building_id);

        for ($i = 1; $i <= $floor->floor_number; $i++) {
            for ($j = 1; $j <= $building->number_per_floor; $j++) {

                $room_num = $building->name . "-" . $room_prefix . "-" . $i . "0" . $j;

                Room::create([
                    'room_number' => $room_num,
                    'building_id' => $request->building_id,
                    'room_type_id' => $request->room_type,
                ]);
            }
        }

        return response()->json(['success' => 'Successfully Added Room!']);
    }
}
