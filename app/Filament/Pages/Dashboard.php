<?php

namespace App\Filament\Pages;

use App\Models\User;
use App\Models\Role;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    public function getHeaderWidgets(): array
    {
        return [
            DashboardStats::class,
        ];
    }
}

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        $adminRole = Role::where('name', 'admin')->first();
        $psychologistRole = Role::where('name', 'psychologist')->first();
        $patientRole = Role::where('name', 'patient')->first();

        return [
            Stat::make('Total Users', User::count())
                ->description('All registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Admins', $adminRole ? User::where('role_id', $adminRole->id)->count() : 0)
                ->description('Administrator users')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('danger'),

            Stat::make('Psychologists', $psychologistRole ? User::where('role_id', $psychologistRole->id)->count() : 0)
                ->description('Psychologist users')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning'),

            Stat::make('Patients', $patientRole ? User::where('role_id', $patientRole->id)->count() : 0)
                ->description('Patient users')
                ->descriptionIcon('heroicon-m-user')
                ->color('success'),
        ];
    }
} 