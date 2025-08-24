<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use App\Models\Review;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditAppointment extends EditRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->record->load('review');
        $data['score'] = $record->review?->score;
        $data['notes'] = $record->review?->notes;

        return $data;
    }

    protected function afterSave(): void
    {
        $appointment = $this->record;
        $user = Auth::user()->load('person');

        // Delete existing review
        Review::where('appointment_id', $appointment->id)
            ->delete();


        // Create new review
        Review::create([
            'appointment_id' => $appointment->id,
            'reviewer_id'    => $user->person->id,
            'score'          => $this->form->getState()['score'],
            'notes'          => $this->form->getState()['notes'],
        ]);
    }
}
