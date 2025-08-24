<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAppointment extends ViewRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->record->load('review');
        $data['score'] = $record->review?->score;
        $data['notes'] = $record->review?->notes;

        return $data;
    }
}
