<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Filament\Pages\Dashboard;

class RedirectToFilamentDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the user's role and convert it to lowercase for panel name
        $role = $request->user()->role;
        $panel = strtolower($role->value);

        // If the current route matches the dashboard route for the panel, continue
        if (Dashboard::getRouteName(panel: $panel) == $request->route()->getName()) {
            return $next($request);
        }

        return $next($request);
    }
}
