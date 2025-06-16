<?php

namespace App\Filament\Widgets;

use App\Models\ChatbotConversation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class ChatbotOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        $totalConversations = ChatbotConversation::count();
        $phpResponses = ChatbotConversation::where('source', 'php')->count();
        $pythonResponses = ChatbotConversation::where('source', 'python')->count();
        
        $sentimentCounts = ChatbotConversation::whereNotNull('sentiment')
            ->select('sentiment', DB::raw('count(*) as count'))
            ->groupBy('sentiment')
            ->pluck('count', 'sentiment')
            ->toArray();
            
        $positiveCount = $sentimentCounts['positive'] ?? 0;
        $negativeCount = $sentimentCounts['negative'] ?? 0;
        $neutralCount = $sentimentCounts['neutral'] ?? 0;
        
        $totalSentimentAnalyzed = $positiveCount + $negativeCount + $neutralCount;
        $positivePercentage = $totalSentimentAnalyzed > 0 
            ? round(($positiveCount / $totalSentimentAnalyzed) * 100) 
            : 0;
            
        $sessionsCount = ChatbotConversation::distinct('session_id')->count('session_id');
        $avgMessagesPerSession = $sessionsCount > 0
            ? round($totalConversations / $sessionsCount, 1)
            : 0;

        return [
            Stat::make('Total Percakapan', $totalConversations)
                ->description('Total pesan yang diproses')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('primary'),
                
            Stat::make('Total Sesi', $sessionsCount)
                ->description("Rata-rata $avgMessagesPerSession pesan per sesi")
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
                
            Stat::make('Sentimen Positif', "$positivePercentage%")
                ->description("$positiveCount dari $totalSentimentAnalyzed dianalisis")
                ->descriptionIcon('heroicon-m-face-smile')
                ->color('success'),
                
            Stat::make('Sumber Respons', "PHP: $phpResponses | Python: $pythonResponses")
                ->description('Jumlah respons berdasarkan sumber')
                ->descriptionIcon('heroicon-m-code-bracket')
                ->color('warning'),
        ];
    }
} 