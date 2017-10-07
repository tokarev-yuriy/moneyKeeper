<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::controller('/account/wallets', 'WalletController');
Route::controller('/account/categories', 'CategoryController');
Route::controller('/account/operations/transfer', 'TransferController');
Route::controller('/account/operations/income', 'IncomeController');
Route::controller('/account/operations/spend', 'SpendController');
Route::controller('/account', 'AccountController');