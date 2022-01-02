<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\src\Seller\Profile\GetProfile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getAdminProfile(): \Illuminate\Http\Response
    {
        return (new \App\src\Seller\Profile\GetProfile)->getSellerInfo();
    }
}
