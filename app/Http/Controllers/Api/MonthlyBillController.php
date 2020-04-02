<?php

namespace App\Http\Controllers\Api;

use App\MonthlyBill;
use App\Http\Controllers\Controller;
use App\Http\Resources\MonthlyBill as MonthlyBillResource;
use Illuminate\Http\Request;

class MonthlyBillController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        /* validation */
        $request->validate([
          'bill_id' => 'required|integer',
          'month' => 'required|string|size:6',
          'amount' => 'required|numeric|between:0.01,99999.99',
        ]);
        /* create new model */
        $monthlyBill = new MonthlyBill;
        $monthlyBill->bill_id = $request->input('bill_id');
        /* authorization */
        $request->authorize('create', $monthlyBill);
        /* populate model */
        $monthlyBill->month = $request->input('month');
        $monthlyBill->amount = $request->input('amount');
        /* save model */
        if($monthlyBill->save()) {
            /* return resource */
            return new MonthlyBillResource($monthlyBill);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MonthlyBill  $monthlyBill
     * @return \Illuminate\Http\Response
     */
    public function show(MonthlyBill $monthlyBill)
    {
        /* authorization */
        $this->authorize('view', $monthlyBill);
        /* return resource */
        return new MonthlyBillResource($monthlyBill);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MonthlyBill  $monthlyBill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MonthlyBill $monthlyBill)
    {
        /* validation */
        $request->validate([
          'id' => 'required|integer',
          'bill_id' => 'required|integer',
          'month' => 'required|string|size:6',
          'amount' => 'required|numeric|between:0.01,99999.99',
        ]);
        /* authorization */
        $request->authorize('update', $monthlyBill);
        /* update model */
        $monthlyBill->bill_id = $request->input('bill_id');
        $monthlyBill->month = $request->input('month');
        $monthlyBill->amount = $request->input('amount');
        /* save model */
        if($monthlyBill->save()) {
            /* return resource */
            return new MonthlyBillResource($monthlyBill);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MonthlyBill  $monthlyBill
     * @return \Illuminate\Http\Response
     */
    public function destroy(MonthlyBill $monthlyBill)
    {
        /* authorization */
        $this->authorize('delete', $monthlyBill);
        /* delete model */
        if($monthlyBill->delete()) {
            /* return resource */
            return new MonthlyBillResource($monthlyBill);
        }
    }
}
