<?php

use App\Http\Controllers\ModuloController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function() {

    Route::view('/inicio', 'home')->name('home');

    Route::resources([
        'usuarios' => UserController::class,
        'perfiles' => PerfilController::class,
        'modulos'  => ModuloController::class,
    ]);

});
