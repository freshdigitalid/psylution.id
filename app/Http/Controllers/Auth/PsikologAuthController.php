<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Psikolog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PsikologAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.psikolog.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $psikolog = Psikolog::where('email', $request->email)->first();

        if (!$psikolog || !Hash::check($request->password, $psikolog->password)) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial yang diberikan tidak cocok dengan catatan kami.'],
            ]);
        }

        if (!$psikolog->isActive()) {
            throw ValidationException::withMessages([
                'email' => ['Akun psikolog tidak aktif.'],
            ]);
        }

        if (!$psikolog->isVerified()) {
            throw ValidationException::withMessages([
                'email' => ['Akun psikolog belum diverifikasi oleh admin.'],
            ]);
        }

        Auth::guard('psikolog')->login($psikolog, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(route('psikolog.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('psikolog')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('psikolog.login');
    }

    public function dashboard()
    {
        return view('psikolog.dashboard');
    }

    public function showRegistrationForm()
    {
        return view('auth.psikolog.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:psikologs',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'license_number' => 'required|string|unique:psikologs',
            'specialization' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
        ]);

        $psikolog = Psikolog::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'license_number' => $request->license_number,
            'specialization' => $request->specialization,
            'experience_years' => $request->experience_years,
            'is_active' => false, // Admin harus mengaktifkan
            'is_verified' => false, // Admin harus verifikasi
        ]);

        return redirect()->route('psikolog.login')
            ->with('success', 'Registrasi berhasil! Akun Anda akan diverifikasi oleh admin.');
    }
} 