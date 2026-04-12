<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ModuloController;

Route::middleware('auth:sanctum')->group(function() {

    Route::name('api.')->group(function() {

        Route::get('/render-sidebar', fn() => view('layouts.sidebar'));
        Route::get('/modulos_raiz', [ModuloController::class, 'modulosRaiz']);
        
        Route::apiResources([
            'modulos' => ModuloController::class
        ]);

    });

});