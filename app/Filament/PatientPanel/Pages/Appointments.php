<?php

namespace App\Filament\PatientPanel\Pages;

use Filament\Pages\Page;

class Appointments extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static string $view = 'filament.patient.appointments';

    protected static ?string $navigationLabel = 'Appointments';

    protected static ?string $title = 'Appointments';

    protected static ?int $navigationSort = 20;
}


