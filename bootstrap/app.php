<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Регистрируем наш middleware с alias
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
        
        // Можно добавить middleware для групп
        $middleware->web([
            // здесь можно добавить middleware для всех web маршрутов
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();