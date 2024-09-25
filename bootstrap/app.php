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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check.login' => \App\Http\Middleware\CheckLogin::class,
            'check.user.modify' => \App\Http\Middleware\CheckUserModify::class,
            'check.role.modify' => \App\Http\Middleware\CheckRoleModify::class,
            'check.permission.modify' => \App\Http\Middleware\CheckPermissionModify::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
