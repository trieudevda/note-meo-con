<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use \App\Http\Middleware\AuthApi;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',//config api laravel 11.9
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.apiCheck' => \App\Http\Middleware\AuthApi::class,
        ]);
        // $middleware->api(
        //     append:[
        //         AuthApi::class,\Illuminate\Routing\Middleware\SubstituteBindings::class,
        //     ]
        // );
        // $middleware->use([
        //     \Illuminate\Http\Middleware\TrustProxies::class,
        //     \Illuminate\Http\Middleware\HandleCors::class,
        //     \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
        //     \Illuminate\Http\Middleware\ValidatePostSize::class,
        //     \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
        //     \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        //     // \Illuminate\Routing\Middleware\SubstituteBindings::class,
        //     AuthApi::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
