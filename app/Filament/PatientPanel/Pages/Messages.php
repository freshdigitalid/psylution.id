<?php

namespace App\Filament\PatientPanel\Pages;

use Filament\Pages\Page;

class Messages extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string $view = 'filament.patient.messages';

    protected static ?string $navigationLabel = 'Messages';

    protected static ?string $title = 'Messages';

    protected static ?int $navigationSort = 40;
}


