<?php

namespace App\Filament\Widgets;

use App\Enums\UserRole;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('All registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Admins', User::where('role', UserRole::Admin)->count())
                ->description('Administrator users')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('danger'),

            Stat::make('Psychologists', User::where('role', UserRole::Psychologist)->count())
                ->description('Psychologist users')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning'),

            Stat::make('Patients', User::where('role', UserRole::Patient)->count())
                ->description('Patient users')
                ->descriptionIcon('heroicon-m-user')
                ->color('success'),
        ];
    }
} 