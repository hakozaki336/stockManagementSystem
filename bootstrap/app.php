<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            return response()->json([
                'message' => '指定されたリソースが見つかりません。'
            ], Response::HTTP_NOT_FOUND);
        });
        // NOTE: このエクセプションはモデルバインディング失敗時にもキャッチする
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'message' => '指定されたリソースが見つかりません。',
            ], Response::HTTP_NOT_FOUND);
        });

        $exceptions->render(function (AccessDeniedHttpException $e, $request) {
            return response()->json([
                'message' => 'このアクションは許可されていません。',
            ], Response::HTTP_FORBIDDEN);
        });

        $exceptions->render(function (Exception $e, $request) {
            return response()->json([
                'message' => 'サーバー側でエラーが発生しました'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    })->create();