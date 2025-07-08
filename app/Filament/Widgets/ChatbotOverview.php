<?php

namespace App\Filament\Widgets;

use App\Models\ChatbotConversation;
use App\Models\ChatbotFaq;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ChatbotOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Total percakapan
        $totalConversations = ChatbotConversation::count();
        
        // Percakapan hari ini
        $todayConversations = ChatbotConversation::whereDate('created_at', Carbon::today())->count();
        
        // Persentase pertumbuhan percakapan dibanding hari sebelumnya
        $yesterdayConversations = ChatbotConversation::whereDate('created_at', Carbon::yesterday())->count();
        $conversationGrowth = $yesterdayConversations > 0 
            ? round((($todayConversations - $yesterdayConversations) / $yesterdayConversations) * 100, 1) 
            : 0;
            
        // Total FAQ
        $totalFaq = ChatbotFaq::count();
        
        // FAQ aktif
        $activeFaq = ChatbotFaq::where('is_active', true)->count();
        
        // Rata-rata sentimen positif (dalam persen)
        $sentimentStats = DB::table('chatbot_conversations')
            ->whereNotNull('sentiment')
            ->selectRaw('
                SUM(CASE WHEN sentiment = "positive" THEN 1 ELSE 0 END) as positive_count,
                COUNT(*) as total
            ')
            ->first();
            
        $positivePercent = $sentimentStats && $sentimentStats->total > 0
            ? round(($sentimentStats->positive_count / $sentimentStats->total) * 100, 1)
            : 0;
        
        return [
            Stat::make('Total Percakapan', $totalConversations)
                ->description('Seluruh percakapan chatbot')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('primary'),
            
            Stat::make('Percakapan Hari Ini', $todayConversations)
                ->description($conversationGrowth > 0 ? "+$conversationGrowth% dari kemarin" : "$conversationGrowth% dari kemarin")
                ->descriptionIcon($conversationGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($conversationGrowth >= 0 ? 'success' : 'danger')
                ->chart([
                    $this->getHourlyConversations(7),
                    $this->getHourlyConversations(6),
                    $this->getHourlyConversations(5),
                    $this->getHourlyConversations(4),
                    $this->getHourlyConversations(3),
                    $this->getHourlyConversations(2),
                    $this->getHourlyConversations(1),
                    $this->getHourlyConversations(0),
                ]),
            
            Stat::make('Sentimen Positif', "$positivePercent%")
                ->description('Dari semua percakapan')
                ->descriptionIcon('heroicon-m-face-smile')
                ->color($positivePercent >= 70 ? 'success' : ($positivePercent >= 40 ? 'warning' : 'danger')),
                
            Stat::make('FAQ Aktif', "$activeFaq dari $totalFaq")
                ->description('Basis pengetahuan chatbot')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
        ];
    }
    
    protected function getHourlyConversations(int $hoursAgo): int
    {
        return ChatbotConversation::where('created_at', '>=', now()->subHours($hoursAgo + 1))
            ->where('created_at', '<', now()->subHours($hoursAgo))
            ->count();
    }
} 