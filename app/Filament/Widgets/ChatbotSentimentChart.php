<?php

namespace App\Filament\Widgets;

use App\Models\ChatbotConversation;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ChatbotSentimentChart extends ChartWidget
{
    protected static ?string $heading = 'Analisis Sentimen Percakapan';

    protected function getData(): array
    {
        $data = ChatbotConversation::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(CASE WHEN sentiment = "positive" THEN 1 END) as positive'),
                DB::raw('COUNT(CASE WHEN sentiment = "negative" THEN 1 END) as negative'),
                DB::raw('COUNT(CASE WHEN sentiment = "neutral" THEN 1 END) as neutral')
            )
            ->whereNotNull('sentiment')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $data->pluck('date')->toArray();
        
        return [
            'datasets' => [
                [
                    'label' => 'Positif',
                    'data' => $data->pluck('positive')->toArray(),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.5)',
                    'borderColor' => 'rgb(34, 197, 94)',
                ],
                [
                    'label' => 'Negatif',
                    'data' => $data->pluck('negative')->toArray(),
                    'backgroundColor' => 'rgba(239, 68, 68, 0.5)',
                    'borderColor' => 'rgb(239, 68, 68)',
                ],
                [
                    'label' => 'Netral',
                    'data' => $data->pluck('neutral')->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => 'rgb(59, 130, 246)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
} 