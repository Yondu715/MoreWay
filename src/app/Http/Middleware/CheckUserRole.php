<?php

namespace App\Http\Middleware;

use App\Exceptions\Auth\Forbidden;
use App\Lib\Token\ITokenManager;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    public function __construct(
        private readonly ITokenManager $tokenManager
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws Exception
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$this->tokenManager->getAuthUser()->hasRole($role)) {
            throw new Forbidden();
        }
        return $next($request);
    }
}
