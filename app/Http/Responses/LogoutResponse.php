<?php

namespace App\Http\Responses;

use Illuminate\Http\RedirectResponse;
use Filament\Http\Responses\Auth\LogoutResponse as BaseLogoutResponse;

class LogoutResponse extends BaseLogoutResponse
{
    public function toResponse($request): RedirectResponse
    {
        $controller = new \App\Http\Controllers\Auth\AuthenticatedSessionController();
        return $controller->destroy($request);
    }
}
