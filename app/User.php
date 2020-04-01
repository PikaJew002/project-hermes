<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the families where the admin is the user
     */
    public function families() {
        $this->hasMany('App\Family');
    }

    /**
     * Get the bills associated with the user
     */
    public function bills() {
        $this->belongsToMany('App\Bill')->withPivot('amount')->withTimestamps();
    }

    /**
     * Get the payments belonging to the user
     */
    public function payments() {
        $this->hasMany('App\Payment');
    }
}
