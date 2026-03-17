<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

require __DIR__.'/auth.php';

Route::fallback(fn(): RedirectResponse => to_route('login'));
