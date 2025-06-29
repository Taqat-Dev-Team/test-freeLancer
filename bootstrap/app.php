<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'admin' => \App\Http\Middleware\admin::class,
            'verified.email' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'client' => \App\Http\Middleware\ClientMiddleware::class,
            'freelancer' => \App\Http\Middleware\FreeLancerMiddleware::class,
            'notVerification' => \App\Http\Middleware\NotVerificationMiddleware::class,

        ]);

        $middleware->appendToGroup('api', [
            \App\Http\Middleware\SetLocale::class,


        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {

        // ValidationException
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'code' => 422,
//                    'message' =>   __('messages.validation_failed'),
                    'message' => collect($e->errors())->first()[0] ?? __('messages.validation_failed'),
                    'errors' => $e->errors(),
                ], 422);
            }
        });

        // ModelNotFoundException
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'code' => 404,
                    'message' => __('messages.resource_not_found'),
                ], 404);
            }
        });

        // AuthenticationException
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'code' => 401,
                    'message' => __('messages.unauthenticated'),
                ], 401);
            }
        });

        // Access Denied Exception
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'code' => 403,
                    'message' => __('messages.Access Denied'),
                ], 403);
            }
        });



        // NotFoundHttpException
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'code' => 404,
                    'message' => __('messages.not_found'),
                ], 404);
            }
        });

        // MethodNotAllowedHttpException
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'code' => 405,
                    'message' => __('messages.method_not_allowed'),
                ], 405);
            }
        });

        // HttpException
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                $statusCode = $e->getStatusCode();
                $message = __('messages.http_errors.' . $statusCode, [], $statusCode);

                return response()->json([
                    'status' => false,
                    'code' => $statusCode,
                    'message' => $message,
                ], $statusCode);
            }
        });

        // Generic Exception
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                if (
                    $e instanceof ValidationException ||
                    $e instanceof ModelNotFoundException ||
                    $e instanceof AuthenticationException ||
                    $e instanceof HttpException
                ) {
                    return null;
                }

                if (app()->environment('production')) {
                    return response()->json([
                        'status' => false,
                        'code' => 500,
                        'message' => __('messages.internal_server_error'),
                    ], 500);
                }

                return response()->json([
                    'status' => false,
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ], 500);
            }
        });

    })->create();
