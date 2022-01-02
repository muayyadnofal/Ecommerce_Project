<?php

namespace App\src\Auth;

use App\Traits\HttpTraits\HttpResponse;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Logout
{
    use HttpResponse;

    public function logout($request): \Illuminate\Http\Response
    {
        // take the token from the header __auth token
        $token = $request->header('auth_token');

        // return error if token fails
        if (!$token) {
            return self::failure('some thing went wrong');
        }

        // delete the token if it's true
        try {
            JWTAuth::setToken($token)->invalidate();
        } catch (TokenInvalidException $ex) {
            return self::failure('some thing went wrong');
        }
        return self::success('logged out successfully');
    }
}
