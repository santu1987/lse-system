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
        /***
         * Entradas
         */
        // Listar todas las entradas (index)
        Route::get('/entradas_le', [EntradaLEController::class, 'index'])->name('entradas_le.index');
        // Mostrar formulario (create)
        Route::get('/entradas_le/create', [EntradaLEController::class, 'create'])->name('entradas_le.create');
        // Guardar nueva entrada (store)
        Route::post('/entradas_le', [EntradaLEController::class, 'store'])->name('entradas_le.store');
        // Actualizar entrada existente (update)
        Route::put('/entradas_le/{id}', [EntradaLEController::class, 'update'])->name('entradas_le.update');
        // Eliminar entrada (delete)
        Route::delete('/entradas_le/{id}', [EntradaLEController::class, 'destroy'])->name('entradas_le.destroy');
        // Mostrar formulario de edición
        Route::get('/entradas_le/{id}/edit', [EntradaLEController::class, 'edit'])
            ->name('entradas_le.edit');
        // Update de la entrada
        Route::put('/entradas_le/{id}', [EntradaLEController::class, 'update'])->name('entradas_le.update');
        /**
         * Entradas LSE
         */
        Route::get('/entradas/lse', [EntradaLSEController::class, 'index'])->name('entradas.lse');
        Route::get('/entradas_lse/create', [EntradaLEController::class, 'create'])->name('entradas_lse.create');
        /**
         * 
         */
        Route::view('/signo-del-dia', 'admin.signo')->name('signo.dia');
        Route::view('/notificaciones', 'admin.notificaciones')->name('notificaciones');
        Route::resource('/categorias', CategoriaController::class)->only(['index','create','store']);
        Route::view('/informes', 'admin.informes')->name('informes');
        Route::view('/productos', 'admin.productos')->name('productos');
        Route::view('/usuarios', 'admin.usuarios')->name('usuarios');

    });
});
