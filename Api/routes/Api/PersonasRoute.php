<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonaController;

Route::prefix('persona')->group(function () {
    Route::get('/', [PersonaController::class, 'index'])->name('index');
    Route::get('/{persona}', [PersonaController::class, 'show'])->name('show')->whereNumber('persona');
    Route::post('/', [PersonaController::class, 'store'])->name('store');
    Route::put('/{persona}', [PersonaController::class, 'update'])->name('update')->whereNumber('persona');
    Route::delete('/{persona}', [PersonaController::class, 'destroy'])->name('destroy')->whereNumber('persona');
});

