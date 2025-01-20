<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Layanan;
use Illuminate\Support\Facades\Log;

class LandingController extends Controller
{
    public function index()
    {
        try {
            $settings = Settings::pluck('value', 'key')->all();
            $layanans = Layanan::where('is_active', true)
                              ->orderBy('order')
                              ->get();

            return view('index', compact('settings', 'layanans'));
            
        } catch (\Exception $e) {
            Log::error('Error in LandingController@index: ' . $e->getMessage());
            
            return view('index', [
                'settings' => Settings::pluck('value', 'key')->all(),
                'layanans' => collect([])
            ]);
        }
    }
}
