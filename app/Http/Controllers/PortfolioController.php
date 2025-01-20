<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Settings;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $settings = Settings::pluck('value', 'key')->all();
        $portfolios = Portfolio::orderBy('created_at', 'desc')->get();
        return view('portofolio', compact('settings', 'portfolios'));
    }

    public function show($id)
    {
        $settings = Settings::pluck('value', 'key')->all();
        $portfolio = Portfolio::findOrFail($id);
        $relatedPortfolios = Portfolio::where('category', $portfolio->category)
            ->where('id', '!=', $portfolio->id)
            ->limit(3)
            ->get();
        
        return view('portfolio.show', compact('settings', 'portfolio', 'relatedPortfolios'));
    }
}