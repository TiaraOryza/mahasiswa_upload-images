<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request; 


Route::resource('mahasiswas', MahasiswaController::class);

Route::get('/search', [MahasiswaController::class, 'search'])->name('search');

?>
