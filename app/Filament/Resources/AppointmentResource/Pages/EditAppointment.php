<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Enums\AppointmentStatus;
use App\Enums\UserRole;
use App\Filament\Resources\AppointmentResource;
use App\Models\Review;
use App\Services\VideoConferencing\VideoConferencingFactory;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $record = $this->record;
        $originalStatus = $record->status;
        $newStatus = $data['status'] ?? $originalStatus;

        // Auto-generate meeting link when appointment is approved and is_online = true
        if (
            Auth::user()->role === UserRole::Psychologist &&
            $record->is_online &&
            $originalStatus !== AppointmentStatus::Approved &&
            $newStatus === AppointmentStatus::Approved->value &&
            empty($data['meet_url'])
        ) {
            try {
                $videoService = VideoConferencingFactory::create();
                
                // Calculate duration in minutes
                $startTime = \Carbon\Carbon::parse($record->start_time);
                $endTime = \Carbon\Carbon::parse($record->end_time);
                $durationMinutes = $startTime->diffInMinutes($endTime);

                // Create meeting
                $meeting = $videoService->createMeeting([
                    'topic' => "Consultation - {$record->patient->first_name} {$record->patient->last_name}",
                    'start_time' => $startTime->toIso8601String(),
                    'duration_minutes' => max(15, $durationMinutes), // Minimum 15 minutes
                    'timezone' => 'Asia/Jakarta',
                ]);

                $data['meet_url'] = $meeting['meeting_url'];
                
                Log::info("Auto-generated meeting link for appointment {$record->id}: {$meeting['meeting_url']}");
            } catch (\Exception $e) {
                Log::error("Failed to auto-generate meeting link for appointment {$record->id}: " . $e->getMessage());
                // Don't block the save, but log the error
                // The psychologist can manually enter the meeting URL
            }
        }

        return $data;
    }

    protected function afterSave(): void
    {
        if(Auth::user()->role == UserRole::Patient) {
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
}
