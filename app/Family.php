<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    /**
     * Get the user who is the admin
     */
    public function admin() {
        $this->belongsTo('App\User');
    }

    /**
     * Get the bills belonging to the family
     */
    public function bills() {
        $this->hasMany('App\Bill');
    }
}
