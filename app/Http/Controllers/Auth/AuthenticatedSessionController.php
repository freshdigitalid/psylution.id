<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Handle rate limiting
        $request->authenticate();
        
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');
        
        // Try to authenticate with different guards in order
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $admin = Auth::guard('admin')->user();
            if (!$admin->isActive()) {
                Auth::guard('admin')->logout();
                throw ValidationException::withMessages([
                    'email' => ['Akun admin tidak aktif.'],
                ]);
            }
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }
        
        if (Auth::guard('psikolog')->attempt($credentials, $remember)) {
            $psikolog = Auth::guard('psikolog')->user();
            if (!$psikolog->isActive()) {
                Auth::guard('psikolog')->logout();
                throw ValidationException::withMessages([
                    'email' => ['Akun psikolog tidak aktif.'],
                ]);
            }
            if (!$psikolog->isVerified()) {
                Auth::guard('psikolog')->logout();
                throw ValidationException::withMessages([
                    'email' => ['Akun psikolog belum diverifikasi oleh admin.'],
                ]);
            }
            $request->session()->regenerate();
            return redirect()->intended(route('psikolog.dashboard'));
        }
        
        if (Auth::guard('pasien')->attempt($credentials, $remember)) {
            $pasien = Auth::guard('pasien')->user();
            if (!$pasien->isActive()) {
                Auth::guard('pasien')->logout();
                throw ValidationException::withMessages([
                    'email' => ['Akun pasien tidak aktif.'],
                ]);
            }
            $request->session()->regenerate();
            return redirect()->intended(route('pasien.dashboard'));
        }
        
        // If no guard succeeded, try the default web guard
        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard', absolute: false));
        }
        
        // If all attempts failed, hit rate limiter and throw error
        \Illuminate\Support\Facades\RateLimiter::hit($request->throttleKey());
        throw ValidationException::withMessages([
            'email' => ['Kredensial yang diberikan tidak cocok dengan catatan kami.'],
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
