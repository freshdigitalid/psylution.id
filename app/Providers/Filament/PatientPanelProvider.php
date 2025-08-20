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
use Filament\Support\Enums\MaxWidth;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PatientPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('patient')
            ->path('patient')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->darkMode(false)
            ->maxContentWidth(MaxWidth::Full)
            ->brandName('Psylution')
            ->discoverResources(in: app_path('Filament/PatientPanel/Resources'), for: 'App\\Filament\\PatientPanel\\Resources')
            ->discoverPages(in: app_path('Filament/PatientPanel/Pages'), for: 'App\\Filament\\PatientPanel\\Pages')
            ->pages([
                \App\Filament\PatientPanel\Pages\Dashboard::class,
                \App\Filament\PatientPanel\Pages\Appointments::class,
                \App\Filament\PatientPanel\Pages\Patients::class,
                \App\Filament\PatientPanel\Pages\Messages::class,
                \App\Filament\PatientPanel\Pages\Reports::class,
                \App\Filament\PatientPanel\Pages\Settings::class,
                Profile::class,
            ])
            ->discoverWidgets(in: app_path('Filament/PatientPanel/Widgets'), for: 'App\\Filament\\PatientPanel\\Widgets')
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
                    ->url(fn () => Profile::getRouteName(panel: 'patient')),
            ]);;
    }
}
