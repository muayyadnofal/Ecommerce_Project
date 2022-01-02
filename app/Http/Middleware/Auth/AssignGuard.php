<?php

namespace App\Http\Middleware\Auth;

use App\Traits\HttpTraits\HttpResponse;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class AssignGuard extends BaseMiddleware
{
    use HttpResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($guard !== null) {
            auth()->shouldUse($guard);

            // put the auth token in bearer authorization
            $token = $request->header('auth_token');
            $request->headers->set('auth_token', (string) $token, true);
            $request->headers->set('Authorization', 'Bearer' . $token, true);

            // try to parse the token to authenticate the user
            try {
                JWTAuth::parseToken()->authenticate();
            } catch (TokenExpiredException | JWTException $e) {
                return self::failure('Unauthenticated User');
            }
        }
        return $next($request);
    }
}
