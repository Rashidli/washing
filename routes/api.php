<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Washing;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::get('/washings', function (){
   $washing = Washing::all();
   return response()->json($washing);
});

Route::post('register', [AuthController::class, 'register']);

Route::post('sendOtp',[AuthController::class,'sendOTP']);
Route::post('verifyOtp',[AuthController::class,'verifyOTP']);

Route::middleware(['auth:sanctum'])->group(function(){

    Route::post('logout', [AuthController::class, 'logout']);

    Route::group(['prefix' => 'reservations'], function(){

        Route::get('/' ,[ReservationController::class, 'show']);
        Route::post('add', [ReservationController::class, 'store']);
        Route::post('update', [ReservationController::class, 'update']);

    });

});
