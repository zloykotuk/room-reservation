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

Route::get('/', function () {
    return view('welcome', [
        'GlobalVariable' => json_encode([
            'indexRoomAjaxUrl' => route('api.room.index'),
            'editReservationAjaxUrl' => route('api.reservation.edit', ['id' => ':id']),
            'changeDateReservationAjaxUrl' => route('api.reservation.changeDate', ['id' => ':id']),
            'deleteReservationAjaxUrl' => route('api.reservation.delete', ['id' => ':id']),
            'indexReservationAjaxUrl' => route('api.reservation.index'),
            'createReservationAjaxUrl' => route('api.reservation.create'),
            'createRoomAjaxUrl' => route('api.room.create'),
        ])
    ]);
});
