<?php

namespace App\Infrastructure\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ApiException extends Exception
{

    public function __construct(string $message = '', int $code = 500)
    {
        $this->message = $message;
        if ($code >= 400 && $code <= 599) {
            $this->code = $code;
        } else {
            $this->code = 500;
        }
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'error' => [
                'message' => $this->message
            ]
        ], $this->code);
    }
}
