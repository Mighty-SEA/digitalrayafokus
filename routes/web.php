<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LandingController;
use App\Models\Settings;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\LayananController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LandingController::class, 'index'])->name('index');

Route::get('/profil', function () {
    $settings = Settings::pluck('value', 'key')->all();
    
    // Tambahkan default settings
    $defaultSettings = [
        'company_name' => 'PT. Digital Raya Fokus',
        'company_tagline' => 'Mitra terpercaya Anda untuk solusi IT yang inovatif',
        'company_description' => 'PT Digital Raya Fokus adalah perusahaan teknologi informasi yang berfokus pada penyediaan solusi digital',
        'company_keywords' => 'IT, Software, Digital Transformation',
        'company_logo' => 'asset/logo.png',
        'company_favicon' => 'asset/logo.png',
        'company_profile' => 'PT Digital Raya Fokus adalah perusahaan teknologi informasi yang berfokus pada penyediaan solusi digital komprehensif untuk mendukung transformasi bisnis.'
    ];

    $settings = array_merge($defaultSettings, $settings);
    
    return view('profil', compact('settings'));
})->name('profil');

Route::get('/contact', function () {
    $settings = Settings::pluck('value', 'key')->all();
    
    // Tambahkan default settings
    $defaultSettings = [
        'company_name' => 'PT. Digital Raya Fokus',
        'company_tagline' => 'Mitra terpercaya Anda untuk solusi IT yang inovatif',
        'company_description' => 'PT Digital Raya Fokus adalah perusahaan teknologi informasi yang berfokus pada penyediaan solusi digital',
        'company_keywords' => 'IT, Software, Digital Transformation',
        'company_logo' => 'asset/logo.png',
        'company_favicon' => 'asset/logo.png',
        'company_address' => 'Jl. Kapten Sarwono No.32, Banjaran Wetan, Kec. Banjaran',
        'company_phone' => '+62 812-3456-7890',
        'company_email' => 'info@digitalrayafokus.com',
        'company_maps' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.65892832923!2d107.59358089999999!3d-7.049305200000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68eb9eed802849%3A0xbd60aa64d1f1b8bd!2sJl.%20Kapten%20Sarwono%20No.32%2C%20Banjaran%20Wetan%2C%20Kec.%20Banjaran%2C%20Kabupaten%20Bandung%2C%20Jawa%20Barat%2040377!5e0!3m2!1sen!2sid!4v1734612867059!5m2!1sen!2sid'
    ];

    $settings = array_merge($defaultSettings, $settings);
    
    return view('contact', compact('settings'));
})->name('contact');

Route::get('/portofolio', [PortfolioController::class, 'index'])->name('portofolio');

Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
Route::get('/layanan/{slug}', [LayananController::class, 'show'])->name('layanan.show');

Route::get('/portofolio', [PortfolioController::class, 'index'])->name('portofolio');
Route::get('/portofolio/{id}', [PortfolioController::class, 'show'])->name('portfolio.show');