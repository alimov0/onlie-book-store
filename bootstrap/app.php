<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'setLocale' => \App\Http\Middleware\SetLocaleMiddleware::class,
            'checkRole' => \App\Http\Middleware\CheckStatusMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if (request()->is('api/*') && $e->getPrevious() instanceof ModelNotFoundException) {
                $model = Str::afterLast($e->getPrevious()->getMessage(), '\\');
                $model = preg_replace('/[^a-zA-Z]/', '', $model); 
                return response()->json(['message' => $model . ' not found'], 404);
            }

            if (request()->is('api/*')) {
                return response()->json(['message' => '404 Not Found'], 404);
            }
        });
    })->create();