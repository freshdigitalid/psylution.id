<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('auth/register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($validated) {
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone_number' => $validated['phone_number'],
                    'password' => Hash::make($validated['password']),
                    'role_id' => 2, // Default to patient role
                    'is_verified' => false,
                ]);

                // Generate OTP
                $otpCode = rand(100000, 999999);
                $expiresAt = now()->addMinutes(5);

                UserOtp::create([
                    'user_id' => $user->id,
                    'otp_code' => $otpCode,
                    'expires_at' => $expiresAt,
                ]);

                // Try to send WhatsApp OTP (optional)
                try {
                    $phoneNumber = preg_replace('/^0/', '62', $user->phone_number);
                    $apiKey = config('services.starsender.api_key');

                    if ($apiKey) {
                        Http::withHeaders([
                            'Authorization' => $apiKey,
                            'Content-Type' => 'application/json',
                        ])->post('https://api.starsender.online/api/send', [
                            'messageType' => 'text',
                            'to' => $phoneNumber,
                            'body' => "Kode OTP Psylution Anda adalah: {$otpCode}. Berlaku selama 5 menit. Jangan bagikan kode ini kepada siapapun.",
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to send WhatsApp OTP: ' . $e->getMessage());
                    // Continue registration even if OTP sending fails
                }

                Auth::login($user);
            });

            session([
                'phone' => $validated['phone_number'],
                'email' => $validated['email'],
            ]);

            return redirect()->route('otp.verify.form');

        } catch (\Exception $e) {
            Log::error('Registration failed: ' . $e->getMessage());
            return back()
                ->withErrors(['error' => 'Registration failed. Please try again.'])
                ->withInput();
        }
    }
}
