<?php

use App\Http\Middleware\CheckModulePermission;
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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectTo(
            guests: '/admin/login',
            users: '/admin/dashboard'
        );
        $middleware->alias([
            'module' => CheckModulePermission::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'admin/client-data',
            'admin/client-data/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
