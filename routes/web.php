<?php

use App\Http\Controllers\DataPenyulangController;
use App\Http\Controllers\GarduIndukController;
use App\Http\Controllers\PenyulangController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrafoDayaController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('gardu-induk', GarduIndukController::class);
    Route::resource('trafo-daya', TrafoDayaController::class);
    Route::resource('penyulang', PenyulangController::class);
    Route::resource('data-penyulang', DataPenyulangController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\PrediksiController;

Route::get('/prediksi', [PrediksiController::class, 'index'])->name('prediksi.index');
Route::post('/prediksi', [PrediksiController::class, 'submit'])->name('prediksi.submit');


use App\Models\DataPenyulang;

Route::get('/cek-data-penyulang', function () {
    return response()->json([
        'jumlah' => DataPenyulang::count(),
        'satu_data' => DataPenyulang::first(),
    ]);
});


require __DIR__.'/auth.php';
