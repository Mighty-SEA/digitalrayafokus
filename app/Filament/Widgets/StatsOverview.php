<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalOrders = DB::table('invoices')->count();
        $cancelledOrders = DB::table('invoices')->where('status', 'cancelled')->count();
        $paidOrders = DB::table('invoices')->where('status', 'paid')->count();
    
        $cancelledPercentage = $totalOrders > 0 ? ($cancelledOrders / $totalOrders) * 100 : 0;
        $paidRatio = $totalOrders > 0 ? $paidOrders . ':' . $totalOrders : '0:0';
    
        return [
            Stat::make('Total Pesanan Masuk', $totalOrders),
            Stat::make('Total Pesanan Dibatalkan ', round($cancelledPercentage, 2) . '%'),
            Stat::make('Total Pesanan Dibayar', $paidRatio),
        ];
    }
}
