<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * Get the user who made the payment
     */
    public function user() {
        $this->belongsTo('App\User');
    }

    /**
     * Get the user who made the payment
     */
    public function monthlyBill() {
        $this->belongsTo('App\MonthlyBill');
    }
}
