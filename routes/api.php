<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\CongressBillController;
use App\Http\Controllers\Api\CongressMemberController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('verification', 'verification');
        Route::post('forgot-password', 'forgotPassword');
        Route::post('re-send-code', 'reSendCode');
        Route::post('social-login', 'socialLogin');
        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('logout', 'logout');
            Route::post('complete-profile', 'completeProfile');
            Route::post('create/preferences', 'createPreferences');
            Route::post('create/member/preferences', 'createMemberPreferences');
            Route::delete('delete-account', 'deleteAccount');
            Route::post('update-password', 'updatePassword');
        });
    });
});

Route::controller(UserController::class)->group(function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('update/profile', 'updateProfile');
    });
});

Route::controller(GeneralController::class)->group(function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('notification/enable', 'enableNotifications');
        Route::post('alert/notification/enable', 'alertEnableNotifications');
        Route::post('user-member-preference', 'userMemberPreference');
        Route::post('my-right/save-remove', 'myRightSaveRemove');
        Route::post('my-right/save-list', 'myRightSaveList');
        Route::post('help-and-feedback', 'helpAndFeedback');
        Route::post('my-right', 'myRight');

        Route::prefix('notification')->group(function () {
            Route::get('list', 'notificationList');
            Route::delete('delete', 'notificationDelete');
            Route::get('unread-count', 'notificationUnreadCount');
        });
    });
    Route::get('preference', 'preference');
    Route::post('get-member-preference', 'getMemberPreference');
    Route::get('get-quote', 'getQoute');
    Route::get('about-app', 'aboutApp');
    Route::get('white-house-detail', 'whiteHouseDetail');
    Route::get('congress-detail', 'congressDetail');
    Route::get('national-debts', 'nationalDebts');
    Route::post('get-budget-function', 'getBudgetFunction');

    Route::get('house-representative-detail', 'houseRepresentativeDetail');
    Route::get('senate-detail', 'senateDetail');
    Route::get('bill-of-right-detail', 'billOfRightDetail');

});


Route::controller(CongressBillController::class)->group(function () {
    Route::post('get-congress-bill', 'getCongressBill');
    Route::get('bill-types', 'billTypes');
    Route::post('filter-bill', 'filterBill');
    Route::post('filter-bill-title', 'filterBillTitle');
    Route::post('executive-orders', 'executiveOrders');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('get-congress-bill-detail', 'getCongressBillDetail');
        Route::post('bill/save-remove', 'billSaveRemove');
        Route::post('bill/save-list', 'BillSaveList');

    });
});

Route::controller(CongressMemberController::class)->group(function () {
    Route::post('get-representative', 'getRepresentative');
    Route::post('get-all-representative', 'getAllRepresentative');
    Route::post('representative/bill', 'representativeBill');
    Route::post('representative/house-senate', 'representativeHouseSenate');
    Route::post('representative/filter-state', 'representativeFilterState');
    Route::post('search/representative', 'searchRepresentative');
    Route::post('compare/representative', 'compareRepresentative');

    Route::get('executive-leader/list', 'executiveLeaderList');


    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('representative/detail', 'representativeDetail');
        Route::post('representative/save-remove', 'representativeSaveRemove');
        Route::post('representative/save-list', 'representativeSaveList');
        Route::post('representative/like-dislike', 'representativeLikeDislike');
        Route::post('representative/like-dislike/list', 'representativeLikeDislikeList');

        Route::post('executive-leader/detail', 'executiveLeaderDetail');
        Route::post('executive-leader/save-remove', 'executiveLeaderSaveRemove');
        Route::post('executive-leader/like-dislike', 'executiveLeaderLikeDislike');
        Route::post('executive-leader/like-dislike/list', 'executiveLeaderLikeDislikeList');

    });
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
