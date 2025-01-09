<?php

namespace App\Http\Controllers;

use App\Models\Settings;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Settings::pluck('value', 'key')->all();
        return view('index', compact('settings'));
    }

    public function profile()
    {
        $settings = Settings::pluck('value', 'key')->all();
        return view('profil', compact('settings'));
    }

    public function portfolio()
    {
        $settings = Settings::pluck('value', 'key')->all();
        return view('portfolio', compact('settings'));
    }

    public function contact()
    {
        $settings = Settings::pluck('value', 'key')->all();
        return view('contact', compact('settings'));
    }

    public function konsultasi()
    {
        $settings = Settings::pluck('value', 'key')->all();
        return view('layanan.konsultasi', compact('settings'));
    }

    public function software()
    {
        $settings = Settings::pluck('value', 'key')->all();
        return view('layanan.software', compact('settings'));
    }

    public function infrastruktur()
    {
        $settings = Settings::pluck('value', 'key')->all();
        return view('layanan.infrastruktur', compact('settings'));
    }

    public function manajemen()
    {
        $settings = Settings::pluck('value', 'key')->all();
        return view('layanan.manajemen', compact('settings'));
    }

    public function pelatihan()
    {
        $settings = Settings::pluck('value', 'key')->all();
        return view('layanan.pelatihan', compact('settings'));
    }
} 