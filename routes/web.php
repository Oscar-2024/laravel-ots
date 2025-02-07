<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SecretController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('secrets', [SecretController::class, 'index'])
    ->middleware('auth')
    ->name('secrets.index');

Route::resource('secrets', SecretController::class)
    ->only(['create', 'store', 'show', 'destroy']);

Route::get('secrets/{secret}/link', [SecretController::class, 'showLink'])
    ->name('secrets.link');

Route::post('secrets/{secret}/decrypt', [SecretController::class, 'decrypt'])
    ->name('secrets.decrypt');
    
require __DIR__.'/auth.php';
