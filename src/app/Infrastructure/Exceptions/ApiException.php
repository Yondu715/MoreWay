<?php

namespace App\Infrastructure\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ApiException extends Exception
{

    // public function __construct(string $message = '', mixed $code = 500)
    // {
    //     parent::__construct($message, $code);
    //     if (!is_int($code) || $code < 100 || $code > 599) {
    //         $this->code = 500;
    //     }
    // }

    public function render(): JsonResponse
    {
        return response()->json([
            'error' => [
                'message' => $this->message
            ]
        ], $this->code);
    }
}
