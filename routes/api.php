<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Affiliator\AffiliatorLoginController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('admin/login',[AdminLoginController::class,'login']);
Route::middleware('throttle:1000,1','auth:sanctum','abilities:user')->group(function () {
    Route::get('admin/info',[AdminLoginController::class,'user_info']);
    Route::get('admin/allAffiliatorInfo',[AdminLoginController::class,'allAffiliatorInfo']);
    Route::get('admin/allAdminInfo',[AdminLoginController::class,'allAdminInfo']);
});
Route::post('affiliator/login',[AffiliatorLoginController::class,'login']);
Route::post('affiliator/signUp',[AffiliatorLoginController::class,'signUp']);
Route::middleware('throttle:1000,1','auth:sanctum','abilities:affiliator')->group(function () {
    Route::get('affiliator/info',[AffiliatorLoginController::class,'user_info']);
});
