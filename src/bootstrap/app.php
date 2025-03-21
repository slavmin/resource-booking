<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Exception $e, Request $request) {
            if ($request->is('api/*')) {
                $statusCode = !empty($e->getCode()) ? $e->getCode() : (!empty($e->status) ? $e->status : 500);
                $message = Str::contains($e->getMessage(), 'No query results for model') ? 'Not Found' : $e->getMessage();
                return response()->json([
                    'message' => $message,
                ], $statusCode);
            }

            return $request->expectsJson();
        });
    })->create();
