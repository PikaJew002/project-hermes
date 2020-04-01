<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthlyBill extends Model
{
    /**
     * Get the parent bill of the monthly bill
     */
    public function bill() {
        $this->belongsTo('App\Bill');
    }

    /**
     * Get the payments on the monthly bill
     */
    public function payments() {
        $this->hasMany('App\Payment');
    }
}
