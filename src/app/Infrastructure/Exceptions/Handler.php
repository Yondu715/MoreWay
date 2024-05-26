<?php

namespace App\Infrastructure\Exceptions;

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
            return response()->json([
                'message' => $apiException->getMessage()
            ], $apiException->getCode());
        });

        $this->renderable(function (InternalException $internalException) {
            return response()->json([
                'message' => $internalException->getMessage()
            ], $internalException->getCode());
        });
    }
}
