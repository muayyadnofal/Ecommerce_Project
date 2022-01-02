<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\src\Auth\Logout;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function logout(Request $request): \Illuminate\Http\Response
    {
        return (new \App\src\Auth\Logout)->logout($request);
    }
}
