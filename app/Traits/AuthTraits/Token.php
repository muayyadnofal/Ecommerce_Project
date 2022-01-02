<?php

namespace App\Traits\AuthTraits;

use Illuminate\Support\Facades\Auth;

trait Token
{
    public function createToken($request, $guard): String
    {
        $credentials = $request->only(['email', 'password']);
        return Auth::guard($guard)->attempt($credentials);
    }
}
