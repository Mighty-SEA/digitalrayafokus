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
    
        // Mengambil data untuk grafik (7 hari terakhir)
        $last7Days = collect(range(6, 0))->map(function ($days) {
            return now()->subDays($days)->format('Y-m-d');
        });

        $dailyOrders = DB::table('invoices')
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->selectRaw('DATE(created_at) as date, count(*) as total')
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $chartData = $last7Days->map(fn ($date) => $dailyOrders[$date] ?? 0)->toArray();
    
        return [
            Stat::make('Total Pesanan Masuk', $totalOrders)
                ->description('Semua pesanan yang masuk ke sistem')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->chart($chartData)
                ->color('primary'),
                
            Stat::make('Total Pesanan Dibatalkan', round($cancelledPercentage, 2) . '%')
                ->description('Persentase pesanan yang dibatalkan')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
                
            Stat::make('Total Pesanan Dibayar', $paidRatio)
                ->description('Rasio pesanan yang sudah dibayar')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}
