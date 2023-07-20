<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Accounting;
use Illuminate\Support\Carbon;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Employee;
use App\Models\PhaseTask;
use App\Models\ProjectPhase;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {
        $projects = Project::with('phases')->get();
        $user = User::all();
        return response()->json([
            'project' => $projects,
            'user' => $user,
        ],200);
    }

    public function store(Request $request)
    {
        //

        $year = Carbon::parse($request->estimatedate)->format('Y');


        if($request->projectvalue && $request->expectedbudget != null){

            $roi = intval($request->projectvalue - $request->expectedbudget);


            $roi_value = ($roi *100 ) / $request->expectedbudget;
        }


        $newName = 'user.jpg';

        if ($request->hasFile('rfqfile')) {

            $newName='file_'.uniqid().".".$request->file('rfqfile')->getClientOriginalName();
            $request->file('rfqfile')->storeAs('public/file',$newName);

		}

            $storesale_project = Project::create([
                'name' =>  $request->projectname,
                'status' => 1,
                'project_contact_person' => $request->contactperson,
                'phone' => $request->phone,
                'email' =>  $request->email,
                'location' => $request->location,
                'submission_date' =>$request->submissiondate,
                'estimate_date' =>$request->estimatedate,
                'rfq_file_path' =>$newName,
                'description' => $request->description,
                'project_value' =>$request->projectvalue??0,
                'expected_budget' => $request->expectedbudget??0,
                'year' => $year,
                'roi_value' => $roi_value ?? 0,
                'customer_id' => $request->customer_id,
                'team' => $request->team,
            ]);

        if($request->projectvalue != null)
        {
           Accounting::create([

                'account_code' => $request->accountcoderev,
                'account_name' => $request->accountnamerev,
                'account_type' => 6,
                'project_id' => $storesale_project->id,
                'amount' => $request->projectvalue,
                'currency_id' => $request->currency,
                'opening_balance' => $request->projectvalue,
            ]);
           Accounting::create([
                'account_code' => $request->accountcoderec,
                'account_name' => $request->accountnamerec,
                'account_type' => 7,
                'project_id' => $storesale_project->id,
                'amount' => $request->projectvalue,
                'currency_id' => $request->currency,
                'opening_balance' => $request->projectvalue,
            ]);
        }
        if($request->expectedbudget != null)
        {
           Accounting::create([
                'account_code' => $request->accountcodecog,
                'account_name' => $request->accountnamecog,
                'account_type' => 10,
                'project_id' => $storesale_project->id,
                'amount' => 0,
                'currency_id' => $request->currency_id,
                'opening_balance' => $request->expectedbudget,
            ]);
           Accounting::create([
                'account_code' => $request->accountcoderec,
                'account_name' => $request->accountnamerec,
                'account_type' => 9,
                'project_id' => $storesale_project->id,
                'amount' => $request->expectedbudget,
                'currency_id' => $request->currency_id,
                'opening_balance' => $request->expectedbudget,
            ]);
        }

       return response()->json([
        'data' => 'success'
       ],200);
    }

    public function getProjectListByid($id)
    {
            $emp=Employee::find($id);
            $phases  =  ProjectPhase::where('user_id',$emp->user_id)->with('project:id,name,project_contact_person,phone,email','phasetasks')->get();

         return response()->json(['phases'=>$phases]);
    }

}
