<?php

use App\Console\Commands\Bills;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\GeneralController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Admin\MyRightController;
use App\Http\Controllers\Admin\ExecutiveLeaderController;
use App\Http\Controllers\Admin\NotificationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('content/{type}', [GeneralController::class, 'content']);

//guest 
Route::group(['middleware' => 'admin.guest'], function () {
    Route::get('', [App\Http\Controllers\AdminController::class, 'loginForm'])->name('admin.login');
    Route::POST('admin/login', [App\Http\Controllers\AdminController::class, 'login'])->name('admin.auth');
});

Route::group(['prefix' => 'admin'], function () {
    //admin authenticate middleware 
    Route::group(['middleware' => 'admin.auth'], function () {
        //dashboard
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.home');
        //admin logout 
        Route::post('logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');

        Route::controller(GeneralController::class)->group(function () {
            Route::get('content/edit/{type}', 'contentEdit');
            Route::post('content/update', 'contentUpdate');

            // white-house-detail Text
            Route::get('white-house-detail', 'whiteHouseDetail');
            Route::post('update-white-house-detail', 'updateWhiteHouseDetail');

            // congress-detail Text
            Route::get('congress-detail', 'congressDetail');
            Route::post('update-congress-detail', 'updateCongressDetail');

            Route::get('house-representative-detail', 'houseRepresentativeDetail');
            Route::post('update-house-representative-detail', 'updateHouseRepresentativeDetail');

            Route::get('senate-detail', 'senateDetail');
            Route::post('update-senate-detail', 'updateSenateDetail');

            Route::get('bill-of-right-detail', 'billOfRightDetail');
            Route::post('update-bill-of-right-detail', 'updateBillOfRightDetail');

            Route::get('help-and-feedback', 'helpAndFeedback');

        });

        Route::controller(SettingController::class)->group(function () {
            Route::get('settings', 'index');
            Route::post('update-setting', 'update');
        });

        // Bills
        Route::controller(BillController::class)->group(function () {
            Route::get('create/congress', 'fetchAndSaveCongressData');

            Route::get('congress/bills', 'congressBills');
            Route::post('create/bills', 'createBills');

            Route::get('congress/member', 'congressmember');
            Route::post('fetch/congress/member', 'fetchCongressmember');
            
            Route::get('executive-orders', 'executiveOrders');
            Route::post('fetch/executive-orders', 'fetchExecutiveOrders');
            
            Route::get('national-debt-budget', 'nationalDebtAndBudget');
            Route::post('fetch/national-debt-budget', 'getNationalDebtAndBudget');
            
            Route::get('spending-data', 'spendingData');
            Route::post('fetch/spending-data', 'getSpendingData');

        });

        Route::controller(QuoteController::class)->group(function(){
            Route::get('quote', 'view');
            Route::get('quote/read', 'read');
            Route::get('quote/create', 'create');
            Route::post('quote/save', 'save');
            Route::get('quote/edit', 'edit');
            Route::post('quote/update', 'update');
            Route::get('quote/delete/{id}', 'delete');
            Route::get('quote/default/{id}', 'default');
        });

        // My Right
        Route::controller(MyRightController::class)->group(function(){
            Route::get('my-right', 'view');
            Route::get('my-right/read', 'read');
            Route::get('my-right/create', 'create');
            Route::post('my-right/save', 'save');
            Route::get('my-right/edit', 'edit');
            Route::post('my-right/update', 'update');
            Route::get('my-right/delete/{id}', 'delete');
        });

        // Executive Leader
        Route::controller(ExecutiveLeaderController::class)->group(function(){
            Route::get('executive', 'view');
            Route::get('executive/read', 'read');
            Route::get('executive/create', 'create');
            Route::post('executive/save', 'save');
            Route::get('executive/edit', 'edit');
            Route::post('executive/update', 'update');
            Route::get('executive/delete/{id}', 'delete');
        });

        Route::controller(NotificationController::class)->group(function () {
            Route::get('notification',  'index');
            Route::post('notification/send', 'sendNotification');
        });
    });
});

Route::get('unauthorize', function () {
    return response()->json([
        'status' => 0,
        'message' => 'Sorry User is Unauthorize'
    ], 401);
})->name('unauthorize');

// Only For Development Purpose
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    //    Artisan::call('log:clear');
    return '<h1>All Cache cleared</h1>';
});
