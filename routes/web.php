<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request; 


Route::resource('mahasiswas', MahasiswaController::class);

Route::get('/search', [App\Http\Controllers\MahasiswaController::class, 'search'])->name('search');
Route::get('mahasiswas/nilai/{Nim}', [App\Http\Controllers\MahasiswaController::class, 'nilai'])->name('mahasiswas.nilai');
Route::get('mahasiswas/cetak_pdf/{Nim}', [App\Http\Controllers\MahasiswaController::class, 'cetak_pdf'])->name('mahasiswas.cetak_pdf');
?>
