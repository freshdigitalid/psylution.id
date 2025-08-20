<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Filament\Pages\Dashboard;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class Controller
{
    public function home()
    {
        return Inertia::render('home/index');
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
        switch (Auth::user()->role) {
            case UserRole::Admin:
                return redirect('/admin/profile');

            case UserRole::Psychologist:
                return redirect('/psychologist/profile');
                
            default:
                return redirect('/patient/profile');
        }
    }
}
