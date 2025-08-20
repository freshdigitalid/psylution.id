<?php

namespace App\Filament\PatientPanel\Pages;

use Filament\Pages\Page;

class Reports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'filament.patient.reports';

    protected static ?string $navigationLabel = 'Report';

    protected static ?string $title = 'Report';

    protected static ?int $navigationSort = 50;
}


