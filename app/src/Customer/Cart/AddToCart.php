<?php

namespace App\src\Customer\Cart;

use App\Models\Product;
use App\Models\User;
use App\Models\UserProduct;
use App\Traits\AuthTraits\GetUser;
use App\Traits\EloquentTraits\Find;
use App\Traits\HttpTraits\HttpResponse;
use Illuminate\Support\Facades\DB;

class AddToCart
{
    use HttpResponse;
    use Find;
    use GetUser;

    public function addProduct($request): \Illuminate\Http\Response
    {
        // request product id and amount
        $id = $request->input('id');
        $amount = $request->input('amount');

        if (!$id || !$amount) {
            return self::failure('uncompleted order');
        }

        // get authenticated user info
        $user = $this->getAuthenticatedUser(User::class);

        // get the requested product info
        $product = $this->findById(Product::class, $id);
        if(!$product) {
            return self::failure('product does not exist');
        }

        // get the User products
        $userProducts = UserProduct::all();

        $exist = $userProducts->where('user_id', 'like', $user->id)
            ->where('product_id', '=', $product->id);

        // check if user ordered this product before
        if (!$exist->isEmpty()) {
            return self::failure('you added this product before');
        }

        // check if the amount value is available
        if ($product->where('amount', 'like', 0)->first()) {
            return self::failure('not available now ');
        }

        if ($amount > $product->amount) {
            return self::failure("The available amount is just {$product->amount}");
        }

        // add product to cart
        DB::table('user_products')->insert(['user_id'=>$user->id, 'product_id'=>$product->id]);
        $product->amount -= $amount;
        $product->save();
        return self::success("product {$product->name} added to cart successfully");
    }

    public function addOneProduct($request): \Illuminate\Http\Response
    {
        // request product id and amount
        $id = $request->input('id');

        if (!$id) {
            return self::failure('uncompleted order');
        }

        // get authenticated user info
        $user = $this->getAuthenticatedUser(User::class);

        // get the requested product info
        $product = $this->findById(Product::class, $id);
        if(!$product) {
            return self::failure('product does not exist');
        }

        // get the User products
        $userProducts = UserProduct::all();

        $exist = $userProducts->where('user_id', 'like', $user->id)
            ->where('product_id', '=', $product->id);

        // check if user ordered this product before
        if (!$exist->isEmpty()) {
            return self::failure('you added this product before');
        }

        // check if the amount value is available
        if ($product->where('amount', 'like', 0)->first()) {
            return self::failure('not available now ');
        }

        --$product->amount;
        $product->save();

        // add product to cart
        DB::table('user_products')->insert(['user_id'=>$user->id, 'product_id'=>$product->id]);
        $product->users()->sync($user);
        $user->products()->sync($product);
        return self::success("product {$product->name} added to cart successfully");
    }
}
