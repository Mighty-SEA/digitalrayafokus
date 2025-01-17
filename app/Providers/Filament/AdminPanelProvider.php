<?php

namespace App\Providers\Filament;

use App\Filament\Resources\SettingsResource;
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

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id("admin")
            ->path("admin")
            ->login()
            ->brandLogo(fn () => view('filament.brand-logo'))
            ->sidebarCollapsibleOnDesktop()
            ->colors([
                "primary" => Color::Amber,
            ])
            ->resources([
                \App\Filament\Resources\InvoiceResource::class,
                \App\Filament\Resources\SettingsResource::class,
                \App\Filament\Resources\UserResource::class,
            ])
            ->discoverPages(
                in: app_path("Filament/Pages"),
                for: "App\\Filament\\Pages"
            )
            ->pages([Pages\Dashboard::class])
            ->widgets([\App\Filament\Widgets\StatsOverview::class])
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
                    ->icon('heroicon-o-cog')
                    ->url(fn(): string => SettingsResource::getUrl('index')),
            ])
            ->profile()
            ->plugin(\Hasnayeen\Themes\ThemesPlugin::make());
    }
}
