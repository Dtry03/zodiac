<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GymClassController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\ClientAreaController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TenantRegistrationController;
use App\Http\Controllers\SubscriptionController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/registrar-gimnasio', [TenantRegistrationController::class, 'create'])->name('tenant.register.form');
Route::post('/registrar-gimnasio', [TenantRegistrationController::class, 'store'])->name('tenant.register.store');

Route::middleware('auth')->group(function () {
    Route::get('/horario', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/inscripciones', [ScheduleController::class, 'todayClasses'])->name('schedule.today');
    Route::post('/inscripciones/{gymClass}', [SignupController::class, 'store'])->name('inscripciones.store');
    Route::delete('/inscripciones/{signup}', [SignupController::class, 'destroy'])->name('inscripciones.destroy');
    Route::get('/gym_classes/{gymClass}/signups', [GymClassController::class, 'showSignups'])->name('gym_classes.signups');
    Route::get('/mis-clases', [ClientAreaController::class, 'myClasses'])->name('client.classes');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/subscription/checkout/{tenant}', [SubscriptionController::class, 'showCheckout'])->name('subscription.checkout.show');
});

 // Importante añadir esto al principio del archivo

// --- Rutas para el Administrador ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('categories', CategoryController::class);
    Route::resource('gym_classes', GymClassController::class);
    Route::resource('users', AdminUserController::class)->except(['create', 'store', 'show' ]);
    Route::get('/listas-dia', [DailyReportController::class, 'dailySignups'])->name('reports.daily_signups');
    Route::get('/listas-dia/pdf', [DailyReportController::class, 'downloadDailySignupsPdf'])->name('reports.daily_signups.pdf');
    Route::get('/clases-hub', [GymClassController::class, 'classesHub'])->name('gym_classes.hub');
    Route::get('/gym_classes/{gymClass}/signups/pdf', [DailyReportController::class, 'downloadClassSignupsPdf'])->name('gym_classes.signups.pdf');
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit'); 
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update'); 


});
// --- Fin Rutas Administrador ---
require __DIR__.'/auth.php';
