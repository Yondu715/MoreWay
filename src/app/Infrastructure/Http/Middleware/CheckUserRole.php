<?php

namespace App\Infrastructure\Http\Middleware;

use App\Application\Contracts\Out\Managers\ITokenManager;
use App\Infrastructure\Exceptions\Forbidden;
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
        if (!$this->tokenManager->hasRole($role)) {
            throw new Forbidden();
        }
        return $next($request);
    }
}
