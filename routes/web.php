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

Route::get('/', 'HomeController@showAccount');
Route::get('/send-payment/form', 'AccountController@showPaymentForm');
Route::post('/send-payment/send', 'AccountController@sendPayment');
Route::get('/send-self/form', 'AccountController@showSelfPaymentForm');
Route::post('/send-self/send', 'AccountController@sendSelfPayment');
Route::get('/generate-report/{accountId}', 'OperationController@generateReport');
Route::get('/logout', 'HomeController@logout');
Route::get('/payment/cancel/{operationId}', 'OperationController@cancel');

Auth::routes();
