<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::namespace('Auth')->group(function() {
    Route::post('login', 'UserController@login');
    Route::post('register', 'UserController@register');
    Route::post('logout', 'UserController@logout');
    Route::get('auth', 'UserController@getUser');
});
Route::namespace('Api')->group(function() {
    Route::apiResources([
      'family' => 'FamilyController',
      'bill' => 'BillController',
      'monthly_bill' => 'MonthlyBillController',
      'payment' => 'PaymentController',
    ]);
    Route::post('bill/user', ['as' => 'bill.attachUser', 'uses' => 'BillController@attachUser']);
    Route::match(['put', 'patch'], 'bill/user/{bill}/{user}', ['as' => 'bill.updatePivotUser', 'uses' => 'BillController@updatePivotUser']);
    Route::delete('bill/user/{bill}/{user}', ['as' => 'bill.detachUser', 'uses' => 'BillController@detachUser']);

    Route::get('user/{user}', ['as' => 'user.show', 'uses' => 'UserController@show']);
});

Route::get('currentroute', function() {
  dd(Route::current()->uri);
});
