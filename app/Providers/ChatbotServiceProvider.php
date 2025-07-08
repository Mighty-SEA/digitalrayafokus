<?php

namespace App\Providers;

use App\Chatbot\ChatbotService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;

class ChatbotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Mendaftarkan layanan chatbot sebagai singleton
        $this->app->singleton(ChatbotService::class, function ($app) {
            return new ChatbotService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Mendaftarkan komponen chatbot
        Blade::component('chatbot-widget', \App\View\Components\ChatbotWidget::class);
        
        // Memastikan view path untuk chatbot tersedia
        $this->loadViewsFrom(__DIR__.'/../../resources/views/components', 'chatbot');
    }
} 