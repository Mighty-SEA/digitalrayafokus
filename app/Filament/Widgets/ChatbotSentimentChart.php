<?php

namespace App\Filament\Widgets;

use App\Models\ChatbotConversation;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ChatbotSentimentChart extends ChartWidget
{
    protected static ?string $heading = 'Analisis Sentimen Chatbot';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $days = 7; // Ambil data 7 hari terakhir
        
        $sentiments = ChatbotConversation::where('created_at', '>=', Carbon::now()->subDays($days))
            ->get()
            ->groupBy(function ($conversation) {
                return Carbon::parse($conversation->created_at)->format('Y-m-d');
            })
            ->map(function ($conversations) {
                // Hitung jumlah sentimen per hari
                $positive = $conversations->where('sentiment', 'positive')->count();
                $negative = $conversations->where('sentiment', 'negative')->count();
                $neutral = $conversations->where('sentiment', 'neutral')->count();
                
                return [
                    'positive' => $positive,
                    'negative' => $negative,
                    'neutral' => $neutral,
                ];
            });
        
        // Siapkan labels (tanggal) dan data untuk chart
        $labels = [];
        $positiveData = [];
        $negativeData = [];
        $neutralData = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::now()->subDays($i)->format('d/m');
            
            $sentiment = $sentiments[$date] ?? ['positive' => 0, 'negative' => 0, 'neutral' => 0];
            $positiveData[] = $sentiment['positive'];
            $negativeData[] = $sentiment['negative'];
            $neutralData[] = $sentiment['neutral'];
        }
        
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Positif',
                    'data' => $positiveData,
                    'backgroundColor' => 'rgba(40, 167, 69, 0.2)',
                    'borderColor' => 'rgb(40, 167, 69)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Negatif',
                    'data' => $negativeData,
                    'backgroundColor' => 'rgba(220, 53, 69, 0.2)',
                    'borderColor' => 'rgb(220, 53, 69)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Netral',
                    'data' => $neutralData,
                    'backgroundColor' => 'rgba(108, 117, 125, 0.2)',
                    'borderColor' => 'rgb(108, 117, 125)',
                    'borderWidth' => 1,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
} 