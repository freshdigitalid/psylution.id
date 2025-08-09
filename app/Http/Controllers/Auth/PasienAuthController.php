<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasienAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.pasien.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $pasien = Pasien::where('email', $request->email)->first();

        if (!$pasien || !Hash::check($request->password, $pasien->password)) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial yang diberikan tidak cocok dengan catatan kami.'],
            ]);
        }

        if (!$pasien->isActive()) {
            throw ValidationException::withMessages([
                'email' => ['Akun pasien tidak aktif.'],
            ]);
        }

        Auth::guard('pasien')->login($pasien, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(route('pasien.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('pasien')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pasien.login');
    }

    public function dashboard()
    {
        return view('pasien.dashboard');
    }

    public function showRegistrationForm()
    {
        return view('auth.pasien.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pasiens',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'emergency_contact' => 'nullable|string|max:20',
        ]);

        $pasien = Pasien::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'emergency_contact' => $request->emergency_contact,
            'is_active' => true, // Pasien langsung aktif
        ]);

        Auth::guard('pasien')->login($pasien);

        return redirect()->route('pasien.dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang di Psylution.');
    }
} 