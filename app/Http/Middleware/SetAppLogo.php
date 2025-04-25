<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;

class SetAppLogo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();

        $logo = match (true) {
            str_starts_with($path, 'health-meal') => 'assets/img/logo_health_meal_new.png',
            str_starts_with($path, 'bank-manager') => 'assets/img/logo_bank_manager.png',
            str_starts_with($path, 'pomodoro-timer') => 'assets/img/logo_pomodoro.png',
            default => 'assets/img/logo_default.png',
        };

        View::share('appLogo', $logo);
        
        return $next($request);
    }
}
