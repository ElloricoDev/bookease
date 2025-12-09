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
            'auth.check' => \App\Http\Middleware\CheckAuth::class,
            'role.check' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule): void {
        // Calculate late fees daily at midnight
        $schedule->command('books:calculate-late-fees')->daily();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
