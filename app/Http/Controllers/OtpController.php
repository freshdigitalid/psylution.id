<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class OtpController extends Controller
{
    /**
     * Show OTP verification form
     */
    public function showVerificationForm()
    {
        if (!session('phone') || !session('email')) {
            return redirect()->route('register');
        }

        return Inertia::render('auth/otp-verify', [
            'phone' => session('phone'),
            'email' => session('email')
        ]);
    }

    /**
     * Verify OTP
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $user = Auth::user();
        
        if (!$user) {
            return back()->withErrors(['error' => 'User not found.']);
        }

        $otp = UserOtp::where('user_id', $user->id)
            ->where('otp_code', $request->otp)
            ->valid()
            ->first();

        if (!$otp) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kadaluarsa.']);
        }

        try {
            DB::transaction(function () use ($user, $otp) {
                // Mark OTP as used
                $otp->update(['is_used' => true]);

                // Mark user as verified
                $user->update(['is_verified' => true]);
            });

            // Clear session
            session()->forget(['phone', 'email']);

            return redirect()->route('dashboard')->with('success', 'Akun berhasil diverifikasi!');

        } catch (\Exception $e) {
            Log::error('OTP verification failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Verifikasi gagal. Silakan coba lagi.']);
        }
    }

    /**
     * Resend OTP
     */
    public function resend()
    {
        $user = Auth::user();
        
        if (!$user) {
            return back()->withErrors(['error' => 'User not found.']);
        }

        try {
            // Invalidate previous OTPs
            UserOtp::where('user_id', $user->id)->update(['is_used' => true]);

            // Generate new OTP
            $otpCode = rand(100000, 999999);
            $expiresAt = now()->addMinutes(5);

            UserOtp::create([
                'user_id' => $user->id,
                'otp_code' => $otpCode,
                'expires_at' => $expiresAt,
            ]);

            // Send WhatsApp OTP
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
                        'body' => "Kode OTP baru Psylution Anda adalah: {$otpCode}. Berlaku selama 5 menit. Jangan bagikan kode ini kepada siapapun.",
                    ]);
                }
            } catch (\Exception $e) {
                Log::warning('Failed to send WhatsApp OTP: ' . $e->getMessage());
            }

            return back()->with('success', 'Kode OTP baru telah dikirim ke WhatsApp Anda.');

        } catch (\Exception $e) {
            Log::error('OTP resend failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal mengirim ulang OTP. Silakan coba lagi.']);
        }
    }
}
