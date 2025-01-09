<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profile'])->name('profile');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/portofolio', [HomeController::class, 'portfolio'])->name('portfolio');
Route::prefix('layanan')->group(function () {
    Route::get('/fitur1', [HomeController::class, 'konsultasi'])->name('layanan.konsultasi');
    Route::get('/fitur2', [HomeController::class, 'software'])->name('layanan.software');
    Route::get('/fitur3', [HomeController::class, 'infrastruktur'])->name('layanan.infrastruktur');
    Route::get('/fitur4', [HomeController::class, 'manajemen'])->name('layanan.manajemen');
    Route::get('/fitur5', [HomeController::class, 'pelatihan'])->name('layanan.pelatihan');
});
