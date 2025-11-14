<?php

namespace App\Services\VideoConferencing;

use Illuminate\Support\Facades\Log;

class VideoConferencingFactory
{
    /**
     * Create video conferencing service instance based on provider
     */
    public static function create(string $provider = null): VideoConferencingInterface
    {
        $provider = $provider ?? config('services.video_conference.provider', 'zoom');

        return match ($provider) {
            'zoom' => new ZoomService(),
            'google_meet' => new GoogleMeetService(),
            default => throw new \InvalidArgumentException("Unsupported video conferencing provider: {$provider}"),
        };
    }
}

