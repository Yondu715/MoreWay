<?php

namespace App\Http\Middleware;

use App\Lib\Token\TokenManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{

    public function __construct(
        private readonly TokenManager $tokenManager
    )
    {
        
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $this->tokenManager->getAuthUser();
        if (!$user->hasRole($role)) {
            dd($user);
            abort(403);
        }
        return $next($request);
    }
}
