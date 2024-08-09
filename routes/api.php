<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HolidayPlanController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->group(function (){
    Route::apiResource('/holidays', HolidayPlanController::class );
    Route::get('/holiday/{id}/pdf', [HolidayPlanController::class, 'getHolidayPdf']);
    Route::get('/holiday/pdf', [HolidayPlanController::class, 'getHolidaysPdf']);


});

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');



