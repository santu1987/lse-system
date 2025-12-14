<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); // Puedes redirigir al login si lo prefieres
});

// Rutas Breeze (ya registradas por el scaffolding)
require __DIR__.'/auth.php';

// Zona admin protegida
Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Ejemplo: módulo administración
    Route::prefix('admin')->group(function () {
        Route::view('/usuarios', 'admin.users.index')->name('admin.users.index');
        // ...otras vistas/recursos
    });
});
