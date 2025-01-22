<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function generate()
    {
        $sitemap = app()->make('sitemap');

        // Halaman Statis
        $sitemap->add(url('/'), Carbon::now(), '1.0', 'daily');
        $sitemap->add(url('/profil'), Carbon::now(), '0.8', 'weekly');
        $sitemap->add(url('/portofolio'), Carbon::now(), '0.8', 'weekly');
        $sitemap->add(url('/layanan'), Carbon::now(), '0.8', 'daily');
        $sitemap->add(url('/contact'), Carbon::now(), '0.8', 'monthly');

        // Layanan Dinamis
        $layanans = Layanan::where('is_active', true)->get();
        foreach ($layanans as $layanan) {
            $sitemap->add(
                url('/layanan/' . $layanan->slug),
                $layanan->updated_at,
                '0.8',
                'weekly'
            );
        }

        return $sitemap->render('xml');
    }
}