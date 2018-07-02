<?php

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

Route::any('/', 'DashboardController@anyIndex');
Route::get('/wallet/{walletId}', 'DashboardController@anyIndex');
Route::post('/wallet/{walletId}', 'DashboardController@anyIndex');

Route::get('/account/login', 'AccountController@getLogin')->name('login');
Route::post('/account/login', 'AccountController@postLogin');
Route::get('/account/logout', 'AccountController@getLogout')->name('logout');
Route::get('/account/register', 'AccountController@getRegister');
Route::post('/account/register', 'AccountController@postRegister');

Route::get('/account/wallets', 'WalletController@getIndex');
Route::get('/account/wallets/delete/{id}', 'WalletController@getDelete');
Route::get('/account/wallets/add', 'WalletController@getAdd');
Route::post('/account/wallets/add', 'WalletController@postAdd');
Route::get('/account/wallets/update/{id}', 'WalletController@getUpdate');
Route::post('/account/wallets/update/{id}', 'WalletController@postUpdate');


Route::any('/account/operations/spend', 'SpendController@getIndex');
Route::get('/account/operations/spend/delete/{id}', 'SpendController@getDelete');
Route::get('/account/operations/spend/add', 'SpendController@getAdd');
Route::post('/account/operations/spend/add', 'SpendController@postAdd');
Route::get('/account/operations/spend/update/{id}', 'SpendController@getUpdate');
Route::post('/account/operations/spend/update/{id}', 'SpendController@postUpdate');

Route::any('/account/operations/income', 'IncomeController@getIndex');
Route::get('/account/operations/income/delete/{id}', 'IncomeController@getDelete');
Route::get('/account/operations/income/add', 'IncomeController@getAdd');
Route::post('/account/operations/income/add', 'IncomeController@postAdd');
Route::get('/account/operations/income/update/{id}', 'IncomeController@getUpdate');
Route::post('/account/operations/income/update/{id}', 'IncomeController@postUpdate');

Route::any('/account/operations/transfer', 'TransferController@getIndex');
Route::get('/account/operations/transfer/delete/{id}', 'TransferController@getDelete');
Route::get('/account/operations/transfer/add', 'TransferController@getAdd');
Route::post('/account/operations/transfer/add', 'TransferController@postAdd');
Route::get('/account/operations/transfer/update/{id}', 'TransferController@getUpdate');
Route::post('/account/operations/transfer/update/{id}', 'TransferController@postUpdate');

Route::get('/account/plans', 'PlanController@getIndex');
Route::get('/account/plans/delete/{id}', 'PlanController@getDelete');
Route::get('/account/plans/add', 'PlanController@getAdd');
Route::post('/account/plans/add', 'PlanController@postAdd');
Route::get('/account/plans/update/{id}', 'PlanController@getUpdate');
Route::post('/account/plans/update/{id}', 'PlanController@postUpdate');

Route::get('/account/categories', 'CategoryController@getIndex');
Route::get('/account/categories/delete/{id}', 'CategoryController@getDelete');
Route::get('/account/categories/add', 'CategoryController@getAdd');
Route::post('/account/categories/add', 'CategoryController@postAdd');
Route::get('/account/categories/update/{id}', 'CategoryController@getUpdate');
Route::post('/account/categories/update/{id}', 'CategoryController@postUpdate');

Route::get('/account/stat/progress/{type?}/{period?}', 'StatisticsController@getProgress');
Route::get('/account/stat/wallets', 'StatisticsController@getWallets');
Route::get('/account/stat/categories/{type?}', 'StatisticsController@getCategories');
Route::get('/account/stat/month', 'StatisticsController@getMonth');
Route::get('/account/stat/monthavg', 'StatisticsController@getMonthavg');
Route::get('/account/stat/monthtotal', 'StatisticsController@getMonthtotal');
Route::get('/account/stat/monthspend', 'StatisticsController@getMonthspend');
Route::get('/account/stat/monthincome', 'StatisticsController@getMonthincome');
Route::get('/account/stat/monthavgtotal', 'StatisticsController@getMonthavgtotal');
Route::get('/account/stat/monthavgspend', 'StatisticsController@getMonthavgspend');
Route::get('/account/stat/monthavgincome', 'StatisticsController@getMonthavgincome');
Route::get('/account/stat/year', 'StatisticsController@getYear');
Route::get('/account/stat/yearavg', 'StatisticsController@getYearavg');
Route::get('/account/stat/yeartotal', 'StatisticsController@getYeartotal');
Route::get('/account/stat/yearspend', 'StatisticsController@getYearspend');
Route::get('/account/stat/yearincome', 'StatisticsController@getYearincome');
Route::get('/account/stat/yearavgtotal', 'StatisticsController@getYearavgtotal');
Route::get('/account/stat/yearavgspend', 'StatisticsController@getYearavgspend');
Route::get('/account/stat/yearavgincome', 'StatisticsController@getYearavgincome');
Route::get('/account/stat/monthplan/{period?}', 'StatisticsController@getMonthplan');
Route::get('/account/stat/yearplan/{period?}', 'StatisticsController@getYearplan');
