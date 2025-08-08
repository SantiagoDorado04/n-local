<?php

use App\Http\Controllers\API\ApiFormController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GeocollectorApiController;
use App\Http\Controllers\API\SchedulesController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);
Route::get('schedules', [SchedulesController::class, 'index']);

Route::middleware('auth:api')->group( function () {
    Route::get('user', [AuthController::class, 'userInfo']);
    Route::get('get-form/{token}',[ApiFormController::class,'getForm']);
    Route::post('send-form/{token}',[ApiFormController::class,'store']);
});

Route::post('send-geocollector',[GeocollectorApiController::class,'index']);