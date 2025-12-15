<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntradaLEController;
use App\Http\Controllers\EntradaLSEController;
use App\Http\Controllers\CategoriaController;

Route::get('/', function () {
    return redirect()->route('login');
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
        Route::get('/entradas/le', [EntradaLEController::class, 'index'])->name('entradas.le');
        Route::get('/entradas/lse', [EntradaLSEController::class, 'index'])->name('entradas.lse');
        Route::view('/signo-del-dia', 'admin.signo')->name('signo.dia');
        Route::view('/notificaciones', 'admin.notificaciones')->name('notificaciones');
        Route::resource('/categorias', CategoriaController::class)->only(['index','create','store']);
        Route::view('/informes', 'admin.informes')->name('informes');
        Route::view('/productos', 'admin.productos')->name('productos');
        Route::view('/usuarios', 'admin.usuarios')->name('usuarios');

    });
});
