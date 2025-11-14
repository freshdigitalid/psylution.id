<?php

namespace App\Services\VideoConferencing;

interface VideoConferencingInterface
{
    /**
     * Create a meeting/room for the appointment
     *
     * @param array $data ['topic', 'start_time', 'duration_minutes', 'timezone']
     * @return array ['meeting_id', 'meeting_url', 'password', 'start_url', 'join_url']
     */
    public function createMeeting(array $data): array;

    /**
     * Get meeting details
     *
     * @param string $meetingId
     * @return array
     */
    public function getMeeting(string $meetingId): array;

    /**
     * Update meeting details
     *
     * @param string $meetingId
     * @param array $data
     * @return array
     */
    public function updateMeeting(string $meetingId, array $data): array;

    /**
     * Delete meeting
     *
     * @param string $meetingId
     * @return bool
     */
    public function deleteMeeting(string $meetingId): bool;
}

