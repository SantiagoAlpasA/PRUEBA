<?php

use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'index')->name('login');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->name('logout');
});


Route::middleware('auth')->group(function () {
    
    
    Route::get('/', [TrabajadorController::class, 'index'])->name('home');
    
    
    Route::post('/trabajadors/guardar', [TrabajadorController::class, 'store'])->name('trabajadors.store');
});