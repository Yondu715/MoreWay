<?php

namespace App\Infrastructure\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetAcceptType
{

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->headers->set('accept', 'application/json');
        return $next($request);
    }
}
