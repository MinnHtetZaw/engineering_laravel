<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectPhase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreProjectPhaseRequest;
use App\Http\Requests\UpdateProjectPhaseRequest;

class ProjectPhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $phases = ProjectPhase::all();
        // return response()->json([
        //     'phase' => $phases
        // ],200);
    }


    public function create()
    {
        //

    }


    public function store(StoreProjectPhaseRequest $request)
    {
        //
		    // DB::table('users')
            //   ->where('id',$request->user_id)
            //   ->update(['work_site_id' => $request->project_id]);

        $projectPhase = new ProjectPhase();
        $projectPhase->phase_name = $request->name;
        $projectPhase->description = $request->description;
        $projectPhase->start_date = $request->start_date;
        $projectPhase->end_date = $request->end_date;
        $projectPhase->user_id = $request->user_id;
        $projectPhase->project_id = $request->project_id;
        $projectPhase->save();

		return response()->json([
            'data' => 'success'
        ],200);
    }


    public function show(ProjectPhase $projectPhase)
    {
        //
    }


    public function edit(ProjectPhase $projectPhase)
    {
        //
    }


    public function update(UpdateProjectPhaseRequest $request, ProjectPhase $projectPhase)
    {
        //
    }

    public function destroy(ProjectPhase $projectPhase)
    {
        //
    }

    public function getPhase($id)
    {

        $data = ProjectPhase::where('project_id',$id)->with('supervisor:id,name')->get();

        return response()->json(['phase'=>$data]);
    }
}
