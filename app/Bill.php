<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    /**
     * Get the family of the bill
     */
    public function family() {
        $this->belongsTo('App\Family');
    }

    /**
     * Get the monthly bills of the bill
     */
    public function monthlyBills() {
        $this->hasMany('App\MonthlyBill');
    }

    /**
     * Get the users the bill is associated with
     */
    public function users() {
        $this->belongsToMany('App\User')->withPivot('amount')->withTimestamps();
    }
}
