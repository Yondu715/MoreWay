<?php

namespace App\Http\Middleware;

use App\Exceptions\Auth\Forbidden;
use App\Lib\Token\TokenManager;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserId
{
    public function __construct(private readonly TokenManager $tokenManager){}

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->tokenManager->getAuthUser()->id !== (int)$request->user_id) {
            throw new Forbidden();
        }
        return $next($request);
    }
}
