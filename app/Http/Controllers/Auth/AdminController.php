<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Admin\LoginRequest;
use App\Http\Requests\Auth\Admin\RegisterRequest;
use App\Http\Resources\Auth\AdminResource;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    // admin register func
    public function register(RegisterRequest $request): \Illuminate\Http\Response
    {
        return (new \App\src\Auth\Register)->register(Admin::class, $request, 'admin_api', 'admin', AdminResource::class);
    }

    // admin login func
    public function login(LoginRequest $request): \Illuminate\Http\Response
    {
        return (new \App\src\Auth\Login)->login($request, 'admin_api', 'admin', AdminResource::class);
    }
}
