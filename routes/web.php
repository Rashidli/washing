<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WashingController;
use App\Http\Controllers\ReservationController;
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
})->name('welcome');


Route::get('admin/admin_exit', [AuthController::class, 'admin_exit'])->name('admin_exit');
Route::get('admin', [AuthController::class, 'index'])->name('admin_login');
Route::post('admin/login_submit', [AuthController::class, 'login_submit'])->name('admin_submit');


Route::group(['middleware' => 'administrator', 'prefix' => 'admin'], function(){

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin_dashboard');
    Route::get('profile', [UserController::class, 'index'])->name('admin_profile');
    Route::post('update/{id}', [UserController::class, 'update'])->name('admin_update');

    Route::group(['prefix'=> 'washing'], function(){
        Route::get('/', [WashingController::class, 'index'])->name('washing');
        Route::post('/add', [WashingController::class,'store'])->name('washing_add');
        Route::get('/edit/{id}', [WashingController::class,'edit'])->name('washing_edit');
        Route::post('/update/{id}', [WashingController::class, 'update'])->name('washing_update');
        Route::get('/delete/{id}', [WashingController::class, 'delete'])->name('washing_delete');
    });

    Route::group(['prefix' => 'reservation'], function(){
       Route::get('/', [ReservationController::class, 'index'])->name('reservation');
    });
});
