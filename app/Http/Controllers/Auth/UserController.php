<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\User\LoginRequest;
use App\Http\Requests\Auth\User\RegisterRequest;
use App\Http\Resources\Auth\AdminResource;
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use App\Traits\HttpTraits\HttpResponse;

class UserController extends Controller
{
    use HttpResponse;

    // admin register func
    public function register(RegisterRequest $request): \Illuminate\Http\Response
    {
        return (new \App\src\Auth\Register)->register(User::class, $request, 'user_api', 'user', UserResource::class);
    }

    // admin login func
    public function login(LoginRequest $request): \Illuminate\Http\Response
    {
        return (new \App\src\Auth\Login)->login($request, 'user_api', 'user', UserResource::class);
    }
}
