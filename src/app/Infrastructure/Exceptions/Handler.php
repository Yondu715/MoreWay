<?php

namespace App\Infrastructure\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Application\Exceptions\InternalException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        $this->renderable(function (ApiException $apiException) {
            return $this->buildJsonResponse($apiException);
        });

        $this->renderable(function (InternalException $internalException) {
            return $this->buildJsonResponse($internalException);
        });
    }

    private function buildJsonResponse(Exception $exception): JsonResponse
    {
        return response()->json([
            'message' => $exception->getMessage()
        ], $exception->getCode());
    }
}
