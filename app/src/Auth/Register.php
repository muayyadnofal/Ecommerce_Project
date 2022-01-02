<?php

namespace App\src\Auth;

use App\Http\Resources\Auth\AdminResource;
use App\Traits\HttpTraits\HttpResponse;
use App\Traits\AuthTraits\Token;

Class Register
{
    use Token;
    use HttpResponse;

    public function register($model, $request, $guard, $type, $recourcename): \Illuminate\Http\Response
    {

        // create a user based on request params
        $user = $model::create(array_merge(
            $request->all(),
            ['password' => bcrypt($request->password)]
        ));

        // insert token to registered user
        $user->api_token = $this->createToken($request, $guard);

        // return handled response for register
        return self::returnData((string)($type), new $recourcename($user), "{$type} registered successfully");
    }
}
