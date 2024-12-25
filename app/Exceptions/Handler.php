<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    public function render($request, Throwable $exception)
    {
        if ($request->is("api/*")) {
            if ($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'status' => 0,
                    'message' => $exception->getMessage(),
                ], 404);
            } elseif ($exception instanceof ValidationException) {
                return response()->json([
                    'status' => 0,
                    'message' => $exception->validator->errors()->first(),
                ], 400);
            } elseif ($exception instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Wrong http method given',
                ], 400);
            } elseif ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Given URL not found on server',
                ], 404);
            } elseif ($exception instanceof  AuthenticationException) {
                return response()->json([
                    'status' =>  0,
                    'message' => $exception->getMessage(),
                ], 401);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => env('APP_DEBUG') ? $exception->getMessage() . ' on line no ' . $exception->getLine() : "Something went wrong",
                ], 500);
            }
        }
        return parent::render($request, $exception);
    }
}
