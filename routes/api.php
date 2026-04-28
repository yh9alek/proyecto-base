<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PerfilController;
use App\Http\Controllers\Api\ModuloController;
use App\Http\Controllers\Api\UserController;

Route::middleware('auth:sanctum')->group(function() {

    Route::name('api.')->group(function() {

        Route::get('/render-sidebar', fn() => view('layouts.sidebar'));

        Route::get('/modulos_raiz',  [ModuloController::class, 'modulosRaiz']);
        Route::get('/modulos/arbol', [ModuloController::class, 'arbol']);
        Route::get('/perfiles/{perfil}/modulos-arbol', [ModuloController::class, 'arbolPorPerfil']);

        Route::apiResources([
            'usuarios' => UserController::class,
            'perfiles' => PerfilController::class,
            'modulos'  => ModuloController::class
        ], [
            'parameters' => [ 'perfiles' => 'perfil' ]
        ]);

    });

});