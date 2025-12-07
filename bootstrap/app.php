<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 1. Trust all proxies (Railway, Fly.io, Render, etc.)
        $middleware->trustProxies(
            headers: Request::HEADER_X_FORWARDED_FOR |
                     Request::HEADER_X_FORWARDED_HOST |
                     Request::HEADER_X_FORWARDED_PORT |
                     Request::HEADER_X_FORWARDED_PROTO |
                     Request::HEADER_X_FORWARDED_AWS_ELB,
            proxies: '*' // Trust every proxy → Railway uses dynamic IPs
        );

        // 2. Force HTTPS in non-local environments
        $middleware->redirectGuestsTo(function () {
            if (!app()->isLocal() && !request()->secure()) {
                return request()->secure() ? null : url()->secure(request()->getRequestUri());
            }
            return null;
        });

        // 3. (Alternative / cleaner) Just force the URL scheme globally)
        // This one line fixes 95 % of the problems on Railway:
        if (!app()->isLocal()) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Optional: give your middlewares aliases like in the old Kernel
        // $middleware->alias([
            // 'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
