<?php

namespace App\Http\Middleware\Auth;

use App\Traits\HttpTraits\HttpResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Protect
{
    use HttpResponse;

    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()) {
            return $next($request);
        }
        return self::failure('Unauthenticated');
    }
}
