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
        // Redirect unauthenticated user sesuai guard:
        // - guard student → /lapor (halaman login inline siswa)
        // - guard lainnya (web/admin) → halaman login admin
        $middleware->redirectGuestsTo(function (\Illuminate\Http\Request $request) {
            if ($request->is('siswa/*') || $request->routeIs('siswa.*')) {
                return route('lapor.index');
            }
            return route('administrator.login');
        });
        $middleware->alias([
        'permission' => \App\Http\Middleware\CheckPermission::class,
    ]);
    $middleware->appendToGroup('web', \App\Http\Middleware\CheckActiveUser::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();