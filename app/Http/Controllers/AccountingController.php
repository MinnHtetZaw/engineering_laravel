<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use App\Http\Requests\StoreAccountingRequest;
use App\Http\Requests\UpdateAccountingRequest;
use App\Models\AccountingType;

class AccountingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $accounting = Accounting::all();
        return response()->json([
            'accounting' => $accounting
        ],200);
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
     * @param  \App\Http\Requests\StoreAccountingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountingRequest $request)
    {
        //
        $accounting = new Accounting();
        $accounting->account_code = $request->code;
        $accounting->account_name = $request->name;
        $accounting->account_type = $request->type;
        $accounting->opening_balance = $request->balance;
        $accounting->amount = $request->balance;
        $accounting->currency_id = $request->curr;
        $accounting->cost_center_id = $request->costcenter;
        $accounting->carry_for_work = $request->carry;
        $accounting->general_project_flag = $request->related;
        $accounting->project_id = $request->projectid;
        $accounting->save();

        return response()->json([
            'data' => 'successfully stored!'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accounting  $accounting
     * @return \Illuminate\Http\Response
     */
    public function show(Accounting $accounting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounting  $accounting
     * @return \Illuminate\Http\Response
     */
    public function edit(Accounting $accounting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAccountingRequest  $request
     * @param  \App\Models\Accounting  $accounting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountingRequest $request, Accounting $accounting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounting  $accounting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accounting $accounting)
    {
        //
    }

    // Account Type
    public function account_type(){
        $account_type = AccountingType::all();
        return response()->json([
            "type" => $account_type
        ],200);
    }
}
