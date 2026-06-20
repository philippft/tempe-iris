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
            'isUser' => \App\Http\Middleware\IsUser::class,
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
            'isDekanat' => \App\Http\Middleware\IsDekanat::class,
            'isPetinggi' => \App\Http\Middleware\IsPetinggi::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
