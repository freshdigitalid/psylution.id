<?php

namespace App\Filament\Pages;

use App\Models\User;
use App\Models\Role;
use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\DashboardStats;

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