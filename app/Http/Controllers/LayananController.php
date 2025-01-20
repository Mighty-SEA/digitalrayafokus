<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Settings;
use Illuminate\Support\Facades\Log;

class LayananController extends Controller
{
    public function index()
    {
        try {
            $settings = Settings::pluck('value', 'key')->all();
            
            $layanans = Layanan::where('is_active', true)
                              ->orderBy('order')
                              ->get();
            
            // Debugging
            Log::info('Layanan count: ' . $layanans->count());
            Log::info('Layanan data: ', $layanans->toArray());
            
            if ($layanans->isEmpty()) {
                Log::warning('No layanan data found');
                $layanans = collect([]);
            }
            
            return view('layanan', compact('settings', 'layanans'));
            
        } catch (\Exception $e) {
            Log::error('Error in LayananController@index: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return view('layanan', [
                'settings' => Settings::pluck('value', 'key')->all(),
                'layanans' => collect([])
            ])->with('error', 'Terjadi kesalahan saat memuat data layanan');
        }
    }

    public function show($slug)
    {
        try {
            $settings = Settings::pluck('value', 'key')->all();
            $service = Layanan::where('slug', $slug)
                             ->where('is_active', true)
                             ->firstOrFail();
            
            return view('layanan.show', compact('settings', 'service'));
            
        } catch (\Exception $e) {
            // Log error
            Log::error('Error in LayananController@show: ' . $e->getMessage());
            
            // Redirect back with error message
            return redirect()->route('layanan.index')
                           ->with('error', 'Layanan tidak ditemukan');
        }
    }
} 