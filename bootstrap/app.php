<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\DummyAuthMiddleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth.jwt' => DummyAuthMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        
        // Validation Exception
        $exceptions->render(function (ValidationException $e, Request $request) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'code' => 422,
                'payload' => $e->errors()
            ], 422);
        });

        // Not Found Exception
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->json([
                'message' => 'Data atau endpoint tidak ditemukan.',
                'code' => 404,
                'payload' => null
            ], 404);
        });

        // Authentication Exception
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return response()->json([
                'message' => 'Unauthenticated.',
                'code' => 401,
                'payload' => null
            ], 401);
        });

        // General Throwable untuk API
        $exceptions->render(function (\Throwable $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                $code = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
                
                // Jangan gunakan 0 untuk HTTP Status Code
                if ($code < 100 || $code > 599) $code = 500;
                
                return response()->json([
                    'message' => $e->getMessage() ?: 'Terjadi kesalahan pada server.',
                    'code' => $code,
                    'payload' => null
                ], $code);
            }
        });

    })->create();
