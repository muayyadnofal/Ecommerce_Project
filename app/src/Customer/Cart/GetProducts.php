<?php

namespace App\src\Customer\Cart;

use App\Http\Resources\Product\ProductResource;
use App\Models\User;
use App\Traits\AuthTraits\GetUser;
use App\Traits\HttpTraits\HttpResponse;

class GetProducts
{
    use GetUser;
    use HttpResponse;

    public function getProducts(): \Illuminate\Http\Response
    {
        $user = $this->getAuthenticatedUser(User::class);
        return self::returnData('cart products', ProductResource::collection($user->products), 'all products from your cart here');
    }
}
