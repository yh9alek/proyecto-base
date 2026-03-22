<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

require __DIR__.'/auth.php';

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');


Route::middleware(['auth', 'verified'])->group(function() {

    Route::view('/usuarios', 'usuarios');
    Route::get('/usuarios/data', [UsuarioController::class, 'data']);

});


Route::fallback(fn(): RedirectResponse => to_route('login'));
