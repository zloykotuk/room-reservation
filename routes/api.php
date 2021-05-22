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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.')->group(function () {
    Route::prefix('room')->group(function () {
        Route::name('room.')->group(function () {
            Route::get('/', [\App\Http\Controllers\RoomController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\RoomController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\RoomController::class, 'store'])->name('store');
        });
    });
    Route::prefix('reservation')->name('reservation.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ReservationController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\ReservationController::class, 'store'])->name('store');
        Route::post('/{id}', [\App\Http\Controllers\ReservationController::class, 'update'])->name('update');
        Route::get('/create', [\App\Http\Controllers\ReservationController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [\App\Http\Controllers\ReservationController::class, 'edit'])->name('edit');
        Route::post('/changeDate/{id}', [\App\Http\Controllers\ReservationController::class, 'changeDate'])->name('changeDate');
        Route::delete('/{id}', [\App\Http\Controllers\ReservationController::class, 'delete'])->name('delete');
    });
});
