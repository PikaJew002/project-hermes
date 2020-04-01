<?php

namespace App\Http\Controllers;

use App\Bill;
use App\User;
use App\Http\Resources\Bill as BillResource;
use Illuminate\Http\Request;

class BillController extends Controller
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
        // maybe return all the users bills?
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
          'family_id' => 'required|integer',
          'name' => 'required|string',
          'start_on' => 'bail|required|date',
          'end_on' => 'required|date|after:'.$request->input('start_on'),
          'amount' => 'required|numeric|between:0.01,99999.99',
          'day_due' => 'nullable|integer|between:1,31',
          'freq_per_year' => 'nullable|integer',
        ]);
        /* create new model */
        $bill = new Bill;
        $bill->family_id = $request->input('family_id');
        /* authorization */
        $request->authorize('create', $bill);
        /* populate model */
        $bill->name = $request->input('name');
        $bill->start_on = $request->input('start_on');
        $bill->end_on = $request->input('end_on');
        $bill->amount = $request->input('amount');
        $bill->day_due = $request->input('day_due');
        $bill->freq_per_year = $request->input('freq_per_year');
        /* save model */
        if($bill->save()) {
            /* return resource */
            return new BillResource($bill);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill)
    {
        /* authorization */
        $request->authorize('view', $bill);
        /* return resource */
        return new BillResource($bill);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        /* validation */
        $request->validate([
          'id' => 'required|integer',
          'family_id' => 'required|integer',
          'name' => 'required|string|max:255|min:2',
          'start_on' => 'bail|required|date',
          'end_on' => 'required|date|after:'.$request->input('start_on'),
          'amount' => 'required|numeric|between:0.01,99999.99',
          'day_due' => 'nullable|integer|between:1,31',
          'freq_per_year' => 'nullable|integer',
        ]);
        /* authorization */
        $request->authorize('update', $bill);
        /* update model */
        // Intros a possible concept for ownership change
        $bill->family_id = $request->input('family_id');
        $bill->name = $request->input('name');
        $bill->start_on = $request->input('start_on');
        $bill->end_on = $request->input('end_on');
        $bill->amount = $request->input('amount');
        $bill->day_due = $request->input('day_due');
        $bill->freq_per_year = $request->input('freq_per_year');
        /* save model */
        if($bill->save()) {
            /* return resource */
            return new BillResource($bill);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        /* authorization */
        $request->authorize('delete', $bill);
        /* delete model */
        if($bill->delete()) {
          /* return resource */
          return new BillResource($bill);
        }
    }

    /**
     * The following functions are for mananging Bill-User associations
     */

    /**
     * Store a newly created bill-user association in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function attachUser(Request $request)
    {
        /* validation */
        $request->validate([
          'bill_id' => 'required|integer',
          'user_id' => 'required|integer',
          'amount' => 'required|numeric|between:0.01,99999.99',
        ]);
        /* find models */
        $bill = Bill::findOrFail($request->input('bill_id'));
        $user = User::findOrFail($request->input('user_id'));
        /* authorization */
        $this->authorize('attachUser', [$bill, $user]);
        /* attach model */
        $bill->users()->attach($request->input('user_id'), [
          'amount' => $request->input('amount')
        ]);
        /* return resource */
        return new BillResource($bill);
    }

    /**
     * Update the specified bill-user association in storage.
     *
     * @param  \App\Bill  $bill
     * @param  \App\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePivotUser(Request $request, Bill $bill, User $user)
    {
        /* validation */
        $request->validate([
          'bill_id' => 'required|integer',
          'user_id' => 'required|integer',
          'amount' => 'required|numeric|between:0.01,99999.99',
        ]);
        /* find models */
        $bill = Bill::findOrFail($request->input('bill_id'));
        $user = User::findOrFail($request->input('user_id'));
        /* authorization */
        $this->authorize('updatePivotUser', [$bill, $user]);
        /* update pivot model */
        $bill->users()->updateExistingPivot($request->input('user_id'), [
          'amount' => $request->input('amount')
        ]);
        /* return resource */
        return new BillResource($bill);
    }

    /**
     * Remove the specified bill-user association from storage.
     *
     * @param  \App\Bill  $bill
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function detachUser(Request $request, Bill $bill, User $user)
    {
        /* validation */
        $request->validate([
          'bill_id' => 'required|integer',
          'user_id' => 'required|integer',
          'amount' => 'required|numeric|between:0.01,99999.99',
        ]);
        /* find models */
        $bill = Bill::findOrFail($request->input('bill_id'));
        $user = User::findOrFail($request->input('user_id'));
        /* authorization */
        $this->authorize('detachUser', [$bill, $user]);
        /* detach model */
        $bill->users()->detach($request->input('user_id'));
        /* return resource */
        return new BillResource($bill);
    }
}
