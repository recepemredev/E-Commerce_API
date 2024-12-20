<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'AdminCheck' => \App\Http\Middleware\AdminMiddleware::class,
            'AuthCheck' => \App\Http\Middleware\CheckAuthMiddleware::class,
            'Log' => \App\Http\Middleware\RequestResponseLogMiddleware::class,
            'RequestLimit' => \App\Http\Middleware\RequestLimitMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
