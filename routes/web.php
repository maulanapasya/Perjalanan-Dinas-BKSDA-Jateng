<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonitoringDinasController;
use App\Http\Controllers\PerjalananDinasController;


Route::get('/', function () {
    return redirect('/login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Route::get('/home', function () {
//     return view('home');
// })->name('home');

Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');



Route::get('/formInputDinas', function () {
    return view('formInputDinas');
})->name('formInputDinas');

Route::get('/monitoringDinas', function () {
    return view('monitoringDinas');
})->name('monitoringDinas');

// Route::get('/loginAuth', function () {
//     return view('loginAuth');
// })->name('loginAuth');

Route::post('/perjalanan-dinas', [PerjalananDinasController::class, 'store'])->name('perjalanan-dinas.store');

Route::get('/monitoringDinas', [MonitoringDinasController::class,'index'])->name('monitoringDinas');

Route::get('/perjalanan-dinas/{id}',[PerjalananDinasController::class,'show'])->name('perjalanan-dinas.show');

Route::get('/perjalanan-dinas/{id}/edit',[PerjalananDinasController::class,'edit'])->name('perjalanan-dinas.edit');

Route::get('/monitoringDinas/search',[MonitoringDinasController::class,'search'])->name('monitoringDinas.search');

Route::put('/perjalanan-dinas/{id}',[PerjalananDinasController::class,'update'])->name('perjalanan-dinas.update');

Route::delete('/perjalanan-dinas/{id}',[PerjalananDinasController::class,'destroy'])->name('perjalanan-dinas.destroy');

Route::get('/monitoring-dinas/export-data', [MonitoringDinasController::class, 'getExportData'])->name('monitoringDinas.getExportData'); // Route untuk mengambil data ekspor

Route::get('/monitoring-dinas/export-selected', [MonitoringDinasController::class, 'exportSelected'])->name('monitoringDinas.exportSelected'); // Route untuk ekspor data terpilih

Route::get('/monitoring-dinas/export-all', [MonitoringDinasController::class, 'exportAll'])->name('monitoringDinas.exportAll'); // Route untuk ekspor semua data
