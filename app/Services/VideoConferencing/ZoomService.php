<?php

namespace App\Services\VideoConferencing;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZoomService implements VideoConferencingInterface
{
    protected string $apiKey;
    protected string $apiSecret;
    protected string $accountId;
    protected string $baseUrl = 'https://api.zoom.us/v2';

    public function __construct()
    {
        $this->apiKey = config('services.zoom.api_key', '');
        $this->apiSecret = config('services.zoom.api_secret', '');
        $this->accountId = config('services.zoom.account_id', '');
    }

    /**
     * Get OAuth access token using Server-to-Server OAuth
     */
    protected function getAccessToken(): string
    {
        // Try OAuth first if account_id and client_secret are configured
        if (!empty($this->accountId) && !empty(config('services.zoom.client_secret'))) {
            $clientId = config('services.zoom.api_key');
            $clientSecret = config('services.zoom.client_secret');
            $credentials = base64_encode($clientId . ':' . $clientSecret);
            
            $response = Http::asForm()->post('https://zoom.us/oauth/token', [
                'grant_type' => 'account_credentials',
                'account_id' => $this->accountId,
            ])->withHeaders([
                'Authorization' => 'Basic ' . $credentials,
            ]);

            if ($response->successful()) {
                return $response->json()['access_token'];
            }
        }

        // Fallback to JWT if OAuth fails or not configured (for backward compatibility)
        return $this->generateJWT();
    }

    /**
     * Generate JWT token for Zoom API (deprecated but works)
     */
    protected function generateJWT(): string
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $payload = [
            'iss' => $this->apiKey,
            'exp' => time() + 3600
        ];

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($header)));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($payload)));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->apiSecret, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    /**
     * Create a Zoom meeting
     */
    public function createMeeting(array $data): array
    {
        try {
            $accessToken = $this->getAccessToken();

            $meetingData = [
                'topic' => $data['topic'] ?? 'Consultation Meeting',
                'type' => 2, // Scheduled meeting
                'start_time' => $data['start_time'] ?? now()->addHour()->toIso8601String(),
                'duration' => $data['duration_minutes'] ?? 60,
                'timezone' => $data['timezone'] ?? 'Asia/Jakarta',
                'settings' => [
                    'host_video' => true,
                    'participant_video' => true,
                    'join_before_host' => false,
                    'mute_upon_entry' => false,
                    'watermark' => false,
                    'waiting_room' => true,
                    'audio' => 'both',
                    'auto_recording' => 'none',
                ],
            ];

            // Use account_id from config as userId
            $userId = config('services.zoom.user_id', 'me');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/users/{$userId}/meetings", $meetingData);

            if ($response->successful()) {
                $meeting = $response->json();
                return [
                    'meeting_id' => (string) $meeting['id'],
                    'meeting_url' => $meeting['join_url'],
                    'password' => $meeting['password'] ?? '',
                    'start_url' => $meeting['start_url'] ?? '',
                    'join_url' => $meeting['join_url'],
                    'provider' => 'zoom',
                ];
            }

            Log::error('Zoom API Error: ' . $response->body());
            throw new \Exception('Failed to create Zoom meeting: ' . $response->body());

        } catch (\Exception $e) {
            Log::error('Zoom Service Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getMeeting(string $meetingId): array
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->get("{$this->baseUrl}/meetings/{$meetingId}");

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Failed to get Zoom meeting: ' . $response->body());
    }

    public function updateMeeting(string $meetingId, array $data): array
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->patch("{$this->baseUrl}/meetings/{$meetingId}", $data);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Failed to update Zoom meeting: ' . $response->body());
    }

    public function deleteMeeting(string $meetingId): bool
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->delete("{$this->baseUrl}/meetings/{$meetingId}");

        return $response->successful();
    }
}

