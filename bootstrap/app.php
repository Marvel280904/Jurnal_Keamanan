<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'prevent-back-history' => \App\Http\Middleware\PreventBackHistory::class,
        ]);

        $middleware->redirectUsersTo(function () {
            if (auth()->check()) {
                $role = auth()->user()->role;
                if ($role === 'Admin') {
                    return '/admin/dashboard';
                } elseif ($role === 'Satpam') {
                    return '/satpam/dashboard';
                } elseif ($role === 'PGA') {
                    return '/pga/dashboard';
                }
            }
            return '/';
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
