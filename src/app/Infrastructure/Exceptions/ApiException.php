<?php

namespace App\Infrastructure\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ApiException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => $this->message
        ], $this->code);
    }
}
