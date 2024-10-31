<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonitoringDinasController;
use App\Http\Controllers\PerjalananDinasController;

// Default Laravel
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/formInputDinas', function () {
    return view('formInputDinas');
})->name('formInputDinas');

Route::get('/monitoringDinas', function () {
    return view('monitoringDinas');
})->name('monitoringDinas');

Route::get('/loginAuth', function () {
    return view('loginAuth');
})->name('loginAuth');

Route::post('/perjalanan-dinas', [PerjalananDinasController::class, 'store'])->name('perjalanan-dinas.store');

Route::get('/monitoringDinas', [MonitoringDinasController::class,'index'])->name('monitoringDinas');

Route::get('/perjalanan-dinas/{id}',[PerjalananDinasController::class,'show'])->name('perjalanan-dinas.show');

Route::get('/perjalanan-dinas/{id}/edit',[PerjalananDinasController::class,'edit'])->name('perjalanan-dinas.edit');

Route::put('/perjalanan-dinas/{id}',[PerjalananDinasController::class,'update'])->name('perjalanan-dinas.update');

Route::delete('/perjalanan-dinas/{id}',[PerjalananDinasController::class,'destroy'])->name('perjalanan-dinas.destroy');

Route::get('/monitoring-dinas', [PerjalananDinasController::class, 'index'])->name('perjalanan-dinas.index');