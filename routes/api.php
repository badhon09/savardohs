<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('payment-request',[\App\Http\Controllers\BillPaymentMaster::class,'makePayment']);
Route::get('payable-bill-list',[\App\Http\Controllers\BillPaymentMaster::class,'PayableBillList']);
Route::group(['middleware' => 'web'], function () {
    Route::get('/getCsrfToken', function() {
       return csrf_token();
       //or return $request->session()->token();
    });
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


