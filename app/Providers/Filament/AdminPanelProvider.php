<?php

namespace App\Providers\Filament;

use App\Filament\Resources\SettingsResource;
use App\Models\Settings;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\Navigation;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {

        try {
            $settings = Schema::hasTable('app_settings') 
                ? Settings::pluck('value', 'key')->all() 
                : [];
            
            $companyName = $settings['company_name'] ?? 'Digital Raya Fokus';
            $companyLogo = isset($settings['company_logo']) && Storage::disk('public')->exists($settings['company_logo']) 
                ? 'storage/' . $settings['company_logo']
                : 'asset/logo.png';
        } catch (\Exception $e) {
            $companyName = 'Digital Raya Fokus';
            $companyLogo = 'asset/logo.png';
        }

        return $panel
            ->default()
            ->id("admin")
            ->path("admin")
            ->login()
            ->registration(false)
            ->authGuard('web')
            ->brandName(isset($settings['company_name']) ? $settings['company_name'] : 'PT Digital Raya Fokus')
            ->brandLogo(isset($settings['company_logo2']) && $settings['company_logo2'] ? asset('storage/' . $settings['company_logo2']) : asset('asset/logo.png'))
            ->brandLogoHeight('3rem')
            ->favicon(isset($settings['company_favicon']) && $settings['company_favicon'] ? asset('storage/' . $settings['company_favicon']) : asset('asset/logo.png'))
            ->sidebarCollapsibleOnDesktop()
            ->colors([
                "primary" => Color::Amber,
            ])
            ->resources([
                // Menu Utama
                \App\Filament\Resources\InvoiceResource::class,
                \App\Filament\Resources\LayananResource::class,
                
                // Menu Content
                \App\Filament\Resources\BlogResource::class,
                \App\Filament\Resources\PortfolioResource::class,
                
                // Menu Chatbot
                \App\Filament\Resources\ChatbotConversationResource::class,
                \App\Filament\Resources\ChatbotFaqResource::class,
                
                // Menu Pengaturan
                \App\Filament\Resources\SettingsResource::class,
                \App\Filament\Resources\UserResource::class,
            ])
            ->navigationGroups([
                'Invoices',
                'Content',
                'Master Data',
                'Chatbot Management',
                'User Management',
                'Settings',
            ])
            ->discoverPages(
                in: app_path("Filament/Pages"),
                for: "App\\Filament\\Pages"
            )
            ->pages([Pages\Dashboard::class])
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class,
            ])
            ->authMiddleware([Authenticate::class])
            ->databaseNotifications()
            ->userMenuItems([
                MenuItem::make()
                    ->label('Settings')
                    ->url(fn (): string => SettingsResource::getUrl())
                    ->icon('heroicon-o-cog-6-tooth'),
            ])
            ->plugin(\Hasnayeen\Themes\ThemesPlugin::make());
    }
}
