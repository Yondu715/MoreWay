<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class BaseException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'error' => [
                'message' => $this->message
            ]
        ], $this->code);
    }
}
