<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GymClassController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SignupController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/horario', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/inscripciones', [ScheduleController::class, 'todayClasses'])->name('schedule.today');
    Route::post('/inscripciones/{gymClass}', [SignupController::class, 'store'])->name('inscripciones.store'); 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\CategoriaController; // Importante añadir esto al principio del archivo

// --- Rutas para el Administrador ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('categories', CategoryController::class);

    Route::resource('gym_classes', GymClassController::class);


});
// --- Fin Rutas Administrador ---
require __DIR__.'/auth.php';
