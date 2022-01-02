<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\src\Customer\Cart\AddToCart;
use App\src\Customer\Product\GetProducts;
use Illuminate\Http\Request;

class cartsController extends Controller
{
    public function store(Request $request): \Illuminate\Http\Response
    {
        return (new \App\src\Customer\Cart\AddToCart)->addProduct($request);
    }

    public function storeOne(Request $request): \Illuminate\Http\Response
    {
        return (new \App\src\Customer\Cart\AddToCart)->addOneProduct($request);
    }

    public function delete(Request $request)
    {
        return (new \App\src\Customer\Cart\DeleteProduct())->deleteProduct($request);
    }

    public function getProducts(): \Illuminate\Http\Response
    {
        return (new \App\src\Customer\Cart\GetProducts)->getProducts();
    }
}
