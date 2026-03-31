<?php

use App\Http\Controllers\EntryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| RUTA PRINCIPAL (REDIRECCIÓN INTELIGENTE)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/entries');
    }

    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (SOLO USUARIOS LOGUEADOS)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | 📊 ENTRIES (CRUD COMPLETO)
    |--------------------------------------------------------------------------
    */

    // READ
    Route::get('/entries', [EntryController::class, 'index'])->name('entries.index');

    // CREATE
    Route::get('/entries/create', [EntryController::class, 'create'])->name('entries.create');
    Route::post('/entries', [EntryController::class, 'store'])->name('entries.store');

    // UPDATE
    Route::get('/entries/{entry}/edit', [EntryController::class, 'edit'])->name('entries.edit');
    Route::put('/entries/{entry}', [EntryController::class, 'update'])->name('entries.update');

    // DELETE
    Route::delete('/entries/{entry}', [EntryController::class, 'destroy'])->name('entries.destroy');


    /*
    |--------------------------------------------------------------------------
    | 📊 DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return redirect('/entries');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | 👤 PERFIL
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN / REGISTER)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';