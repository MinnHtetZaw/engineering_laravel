<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        return response()->json([
            'companies' => $companies,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'company_address' => 'required',
            'company_contact' => 'required',
            'company_email' => 'required',
            'company_md_name' => 'required',
            'financial_start_date' => 'required',
            'financial_end_date' => 'required',
            'starting_capital' => 'required',
            'netprofit_pre_year' => 'required',
            'netprofit_current_year' => 'required',
        ]);
        Company::create([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_contact' => $request->company_contact,
            'company_email' => $request->company_email,
            'company_md_name' => $request->company_md_name,
            'financial_start_date' => $request->financial_start_date,
            'financial_end_date' => $request->financial_end_date,
            'starting_capital' => $request->starting_capital,
            'netprofit_pre_year' => $request->netprofit_pre_year,
            'netprofit_current_year' => $request->netprofit_current_year,
        ]);
        return response()->json([
            'success' => 'Company was saved!'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::whereId($id)->first();
        return response()->json([
            'company' => $company
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required',
            'company_address' => 'required',
            'company_contact' => 'required',
            'company_email' => 'required',
            'company_md_name' => 'required',
            'financial_start_date' => 'required',
            'financial_end_date' => 'required',
            'starting_capital' => 'required',
            'netprofit_pre_year' => 'required',
            'netprofit_current_year' => 'required',
        ]);
        Company::where('id', $id)->update([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_contact' => $request->company_contact,
            'company_email' => $request->company_email,
            'company_md_name' => $request->company_md_name,
            'financial_start_date' => $request->financial_start_date,
            'financial_end_date' => $request->financial_end_date,
            'starting_capital' => $request->starting_capital,
            'netprofit_pre_year' => $request->netprofit_pre_year,
            'netprofit_current_year' => $request->netprofit_current_year,
        ]);
        return response()->json([
            'success' => 'Company was saved!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Company::where('id', $id)->delete();
        return response()->json([
            'success'=>'Company was deleted!'
        ], 200);
    }
}
