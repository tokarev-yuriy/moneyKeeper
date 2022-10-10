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

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SpaController;
use Illuminate\Support\Facades\Route;

Route::any('/', 'DashboardController@anyIndex');


Route::middleware(['auth'])->group(function () {
    Route::prefix('app')->group(function(){
        // Accounht group
        Route::controller(AccountGroupController::class)->group(function(){
            Route::get("account/groups", "list");
            Route::post("account/groups", "add");
            Route::put("account/groups/{id}", "update");
            Route::delete("account/groups/{id}", "delete");
        });
    });
});


Route::get('/wallet/{walletId}', 'DashboardController@anyIndex');
Route::post('/wallet/{walletId}', 'DashboardController@anyIndex');

Route::get('/auth/login', [SpaController::class, 'index'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/auth/register', [AuthController::class, 'register']);
Route::get('/auth/state', [AuthController::class, 'getState']);

Route::get('/account/wallets/groups', 'WalletGroupController@getIndex');
Route::get('/account/wallets/groups/delete/{id}', 'WalletGroupController@getDelete');
Route::get('/account/wallets/groups/add', 'WalletGroupController@getAdd');
Route::post('/account/wallets/groups/add', 'WalletGroupController@postAdd');
Route::get('/account/wallets/groups/update/{id}', 'WalletGroupController@getUpdate');
Route::post('/account/wallets/groups/update/{id}', 'WalletGroupController@postUpdate');

Route::get('/account/wallets', 'WalletController@getIndex');
Route::get('/account/wallets/delete/{id}', 'WalletController@getDelete');
Route::get('/account/wallets/add', 'WalletController@getAdd');
Route::post('/account/wallets/add', 'WalletController@postAdd');
Route::any('/account/wallets/edit/{id}', 'WalletController@getEdit');
Route::get('/account/wallets/update/{id}', 'WalletController@getUpdate');
Route::post('/account/wallets/update/{id}', 'WalletController@postUpdate');


Route::any('/account/operations/delete/{id}', 'OperationController@getDelete');
Route::any('/account/operations/edit/{id}', 'OperationController@getEdit');
Route::post('/account/operations/add', 'OperationController@postAdd');
Route::post('/account/operations/update/{id}', 'OperationController@postUpdate');
Route::post('/account/operations/filter', 'OperationController@postFilter');
Route::any('/account/operations/{type?}', 'OperationController@getIndex');

Route::get('/account/plans', 'PlanController@getIndex');
Route::get('/account/plans/delete/{id}', 'PlanController@getDelete');
Route::get('/account/plans/add', 'PlanController@getAdd');
Route::post('/account/plans/add', 'PlanController@postAdd');
Route::any('/account/plans/edit/{id}', 'PlanController@getEdit');
Route::get('/account/plans/update/{id}', 'PlanController@getUpdate');
Route::post('/account/plans/update/{id}', 'PlanController@postUpdate');

Route::get('/account/categories', 'CategoryController@getIndex');
Route::get('/account/categories/delete/{id}', 'CategoryController@getDelete');
Route::get('/account/categories/add', 'CategoryController@getAdd');
Route::post('/account/categories/add', 'CategoryController@postAdd');
Route::any('/account/categories/edit/{id}', 'CategoryController@getEdit');
Route::get('/account/categories/update/{id}', 'CategoryController@getUpdate');
Route::post('/account/categories/update/{id}', 'CategoryController@postUpdate');

Route::get('/account/stat/progress/{type?}/{period?}', 'StatisticsController@getProgress');
Route::get('/account/stat/wallets/{period?}', 'StatisticsController@getWallets');
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
Route::get('/account/stat/plan/{type?}/{period?}', 'StatisticsController@getPlan');
Route::get('/account/stat/totals/{type?}/{period?}', 'StatisticsController@getTotals');

Route::get('/account/import', 'ImportController@getIndex');
Route::post('/account/import', 'ImportController@postIndex');
Route::get('/account/sync', 'IntegrationController@getIndex');

Route::get('/account/import/profile', 'ImportProfileController@getIndex');
Route::get('/account/import/profile/delete/{id}', 'ImportProfileController@getDelete');
Route::get('/account/import/profile/add', 'ImportProfileController@getAdd');
Route::post('/account/import/profile/add', 'ImportProfileController@postAdd');
Route::get('/account/import/profile/update/{id}', 'ImportProfileController@getUpdate');
Route::post('/account/import/profile/update/{id}', 'ImportProfileController@postUpdate');

Route::get('/account/import/integration', 'IntegrationController@getIndex');
Route::get('/account/import/integration/delete/{id}', 'IntegrationController@getDelete');
Route::get('/account/import/integration/add', 'IntegrationController@getAdd');
Route::post('/account/import/integration/add', 'IntegrationController@postAdd');
Route::get('/account/import/integration/update/{id}', 'IntegrationController@getUpdate');
Route::post('/account/import/integration/update/{id}', 'IntegrationController@postUpdate');
Route::get('/account/import/integration/sync/{id}', 'IntegrationController@getSync');
Route::post('/account/import/integration/sync/{id}', 'IntegrationController@postSync');


/**
 *  Vue router
 *  Proccess other requests with Vue router
 */
Route::get('/{any}', 'SpaController@index')->where('any', '^(?!api).*$')->name('spa');