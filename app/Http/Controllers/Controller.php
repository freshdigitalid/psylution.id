<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Filament\Pages\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class Controller
{
    public function home()
    {
        return Inertia::render('home/index');
    }

    public function about()
    {
        return Inertia::render('about/index');
    }

    public function service()
    {
        return Inertia::render('services/index');
    }

    public function dashboard()
    {
        switch (Auth::user()->role) {
            case UserRole::Admin:
                return redirect()->route(Dashboard::getRouteName(panel: 'admin'));

            case UserRole::Psychologist:
                return redirect()->route(Dashboard::getRouteName(panel: 'psychologist'));
                
            default:
                return redirect()->route(Dashboard::getRouteName(panel: 'patient'));
        }
    }

    public function profile()
    {
        $user = Auth::user();
        
        return Inertia::render('auth/profile', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'avatar' => $user->avatar ? asset('storage/' . $user->avatar) : null,
                'created_at' => $user->created_at,
            ]
        ]);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        
        // Delete old avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        
        // Update user avatar
        $user->update(['avatar' => $avatarPath]);

        // Return redirect for Inertia.js
        return redirect()->back()->with('success', 'Avatar updated successfully');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}
