<?php

use App\Http\Controllers\Api\V1\Admin\TravelController as AdminTravelController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\TourController;
use App\Http\Controllers\Api\V1\TravelController;
use Illuminate\Support\Facades\Route;


Route::get( '/travels', [ TravelController::class, 'index' ] );
Route::get( '/travels/{travel:slug}/tours', [ TourController::class, 'index' ] );

Route::prefix( '/admin' )->middleware( ['auth:sanctum', 'role:admin'] )->group( function() {
    Route::post( '/travels', [ AdminTravelController::class, 'store' ]);
});

Route::post( '/login', [LoginController::class, 'login'] );
