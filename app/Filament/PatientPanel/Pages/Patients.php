<?php

namespace App\Filament\PatientPanel\Pages;

use Filament\Pages\Page;

class Patients extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static string $view = 'filament.patient.patients';

    protected static ?string $navigationLabel = 'Patients';

    protected static ?string $title = 'Patients';

    protected static ?int $navigationSort = 30;
}


