<?php

namespace App\src\Auth;

use App\Http\Resources\Auth\AdminResource;
use App\Traits\AuthTraits\Token;
use App\Traits\HttpTraits\HttpResponse;
use Illuminate\Support\Facades\Auth;

class Login
{
    use HttpResponse;
    use Token;

    public function login ($request, $guard, $type, $recourcename): \Illuminate\Http\Response
    {
        // create a token for user
        $token = $this->createToken($request, $guard);
        if (!$token) {
            return self::failure('invalid login details');
        }

        // get user info
        $user = Auth::guard($guard)->user();
        $user->api_token = $token;

        // return handled logged in response
        return self::returnData((string)($type), new $recourcename($user), "{$type} logged in successfully");
    }
}
