<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Profile;
use App\Http\Middleware\RedirectToFilamentDashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
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
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PsychologistPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('psychologist')
            ->path('psychologist')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/PsychologistPanel/Resources'), for: 'App\\Filament\\PsychologistPanel\\Resources')
            ->discoverPages(in: app_path('Filament/PsychologistPanel/Pages'), for: 'App\\Filament\\PsychologistPanel\\Pages')
            ->pages([
                Pages\Dashboard::class,
                Profile::class,
            ])
            ->discoverWidgets(in: app_path('Filament/PsychologistPanel/Widgets'), for: 'App\\Filament\\PsychologistPanel\\Widgets')
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
            ])
            ->authMiddleware([
                RedirectToFilamentDashboard::class,
                Authenticate::class,
            ])
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label('Profile')
                    ->icon('heroicon-o-user-circle')
                    ->url(fn () => Profile::getRouteName(panel: 'psychologist')),
            ])
            ->resources([
                \App\Filament\Resources\AppointmentResource::class,
            ]);
    }
}
