<?php

namespace App\Providers\Filament;

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

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->brandName("PT Digital Raya Fokus")
            ->default()
            ->id("admin")
            ->path("admin")
            ->login()
            ->colors([
                "primary" => Color::Amber,
            ])
            // ->discoverResources(
            //     in: app_path("Filament/Resources"),
            //     for: "App\\Filament\\Resources"
            // )
            ->resources([
                \App\Filament\Resources\InvoiceResource::class,
                \App\Filament\Resources\CompaniesResource::class,
            ])
            ->discoverPages(
                in: app_path("Filament/Pages"),
                for: "App\\Filament\\Pages"
            )
            ->pages([Pages\Dashboard::class])
            // ->discoverWidgets(
            //     in: app_path("Filament/Widgets"),
            //     for: "App\\Filament\\Widgets"
            // )
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
                    ->label("Company Settings")
                    ->icon("heroicon-o-cog") // Optional: tambahkan icon
                    ->url(
                        fn(): string => \App\Filament\Resources\CompaniesResource::getUrl(
                            "edit",
                            [
                                "record" => 1,
                            ]
                        )
                    ),
            ])
            ->plugin(\Hasnayeen\Themes\ThemesPlugin::make())
            ->sidebarCollapsibleOnDesktop();
    }
}
