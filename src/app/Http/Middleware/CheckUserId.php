<?php

namespace App\Http\Middleware;

use App\Exceptions\Auth\Forbidden;
use App\Lib\Token\Interfaces\ITokenManager;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserId
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
    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->userId ?? $request->route('userId');
        if ($this->tokenManager->getAuthUser()->id !== (int)$userId) {
            throw new Forbidden();
        }
        return $next($request);
    }
}
