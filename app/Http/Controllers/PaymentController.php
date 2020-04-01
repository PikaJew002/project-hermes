<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Http\Resources\Payment as PaymentResource;
use Illuminate\Http\Request;

class PaymentController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* authorization */
        $this->authorize('viewAny');
        $payments = Payment::all();
        /* return resource collection */
        return PaymentResource::collection($payments);
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
          'user_id' => 'required|integer',
          'monthly_bill_id' => 'required|integer',
          'amount' => 'required|numeric|between:0.01,99999.99',
        ]);
        /* create model */
        $payment = new Payment;
        $payment->user_id = $request->input('user_id');
        $payment->monthly_bill_id = $request->input('monthly_bill_id');
        /* authorization */
        $this->authorize('create', $payment);
        /* populate model */
        $payment->amount = $request->input('amount');
        /* save model */
        if($payment->save()) {
            /* return resource */
            return new PaymentResource($payment);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        /* authorization */
        $this->authorize('view', $payment);
        /* return resource */
        return new PaymentResource($payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        /* validation */
        $request->validate([
          'id' => 'required|integer',
          'user_id' => 'required|integer',
          'monthly_bill_id' => 'required|integer',
          'amount' => 'required|numeric|between:0.01,99999.99',
        ]);
        /* authorization */
        $this->authorize('update', $payment);
        /* update model */
        $payment->user_id = $request->input('user_id');
        $payment->monthly_bill_id = $request->input('monthly_bill_id');
        $payment->amount = $request->input('amount');
        /* save model */
        if($payment->save()) {
            /* return resource */
            return new PaymentResource($payment);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        /* authorization */
        $this->authorize('delete', $payment);
        /* delete model */
        if($payment->delete()) {
            /* return resource */
            return new PaymentResource($payment);
        }
    }
}
