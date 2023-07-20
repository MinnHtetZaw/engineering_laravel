<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //

    public function getEmployee()
    {
        $employee = Employee::with('user:id,name,email','role:id,role')->get();
        return response()->json(['employee'=>$employee]);
    }

}
