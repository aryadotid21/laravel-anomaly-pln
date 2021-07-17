<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::multiauth('Admin', 'admin');

Route::multiauth('Operator', 'operator');


Route::middleware(['auth:'.'admin'])->name('admin'.'.')->prefix('admin')->group(function(){
    Route::resource('coordinate','App\Http\Controllers\Admin\CoordinateController');
    Route::delete('coordinate/delete/{id}','App\Http\Controllers\Admin\CoordinateController@destroy')->name('coordinate.delete');

    Route::resource('operator','App\Http\Controllers\Admin\OperatorController');
    Route::delete('operator/delete/{id}','App\Http\Controllers\Admin\OperatorController@destroy')->name('operator.delete');

});