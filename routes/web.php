<?php

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MataKuliahController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('mahasiswa.index');
});

Route::get('/report', [ReportController::class, 'index'])
    ->name('report.index');

Route::get('mahasiswa/export-csv', [MahasiswaController::class, 'exportCsv'])->name('mahasiswa.export-csv');
Route::post('mahasiswa/import-csv', [MahasiswaController::class, 'importCsv'])->name('mahasiswa.import-csv');
Route::resource('mahasiswa', MahasiswaController::class);
Route::resource('dosen', DosenController::class);
Route::resource('mata-kuliah', MataKuliahController::class);
