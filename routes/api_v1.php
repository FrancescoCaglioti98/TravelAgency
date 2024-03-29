<?php

use App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\TourController;
use App\Http\Controllers\Api\V1\TravelController;
use Illuminate\Support\Facades\Route;

Route::get('/travels', [TravelController::class, 'index']);
Route::get('/travels/{travel:slug}/tours', [TourController::class, 'index']);

Route::prefix('/admin')->middleware(['auth:sanctum'])->group(function () {

    Route::middleware('role:admin')->group(function () {
        Route::post('/travels', [Admin\TravelController::class, 'store']);
        Route::put('/travels/{travel}', [Admin\TravelController::class, 'update']);
    });

    // Per il momento gli unici utenti che possono autenticarsi tramite le API sono EDITOR e ADMIN
    // Ed ha senso che entrambi possano modificare i tour creati
    // Come andrà a modificarsi la lista degli utenti sarà necessario creare un altro gruppo per le rotte a cui possono accedere sia gli admin che gli editor
    // Avrei potuto creare i token assegnando direttamente i ruoli come permessi all'interno del token e andando a creare dei middleware custom per ogni tipo di rotta (nel nostro caso solo due)
    // Ma ho la sensazione che mi sarei solo complicato la vita rispetto a quanto fatto adesso
    Route::post('/travels/{travel}/tours', [Admin\TourController::class, 'store']);

});

Route::post('/login', [LoginController::class, 'login']);
