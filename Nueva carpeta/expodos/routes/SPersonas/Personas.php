<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonasController;

Route::prefix('persona')->group(function () {
    Route::get('/', [PersonasController::class, 'index'])->name('index');
    Route::get('/{persona}', [PersonasController::class, 'show'])->name('show')->whereNumber('persona');
    Route::post('/', [PersonasController::class, 'store'])->name('store');
    Route::put('/{persona}', [PersonasController::class, 'update'])->name('update')->whereNumber('persona');
    Route::delete('/{persona}', [PersonasController::class, 'destroy'])->name('destroy')->whereNumber('persona');
});

