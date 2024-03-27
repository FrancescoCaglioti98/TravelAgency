<?php


use App\Http\Controllers\Api\V1\TourController;
use App\Http\Controllers\Api\V1\TravelController;
use Illuminate\Support\Facades\Route;


Route::get( '/travels', [ TravelController::class, 'index' ] );
Route::get( '/travels/{travel:slug}/tours', [ TourController::class, 'index' ] );
