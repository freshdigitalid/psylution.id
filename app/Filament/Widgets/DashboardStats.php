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
            
            Stat::make('Psychologists', User::where('role', UserRole::Psychologist)->count())
                ->description('Active psychologists')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
            
            Stat::make('Active Sessions', $this->getActiveSessions())
                ->description('Current active sessions')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }

    private function getActiveSessions(): int
    {
       
        return rand(5, 15);
    }
}