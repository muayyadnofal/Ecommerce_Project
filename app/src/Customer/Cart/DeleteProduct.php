<?php

namespace App\src\Customer\Cart;

use App\Models\Product;
use App\Models\User;
use App\Models\UserProduct;
use App\Traits\AuthTraits\GetUser;
use App\Traits\EloquentTraits\Find;
use App\Traits\HttpTraits\HttpResponse;

class DeleteProduct
{
    use HttpResponse;
    use GetUser;
    use Find;

    public function deleteProduct($request): \Illuminate\Http\Response
    {
        $id = $request->input('id');

        if(!$id) {
            return self::failure('uncompleted order');
        }

        // get authenticated user info
        $user = $this->getAuthenticatedUser(User::class);

        $userProducts = $user->products()->get();

        $user_product = $userProducts->where('id', $id);
        if ($user_product->isEmpty()) {
            return self::failure('product does not belong to user');
        }

        $user_products = UserProduct::all();
        $selected_product = $user_products->where('user_id', 'like', $user->id)
            ->where('product_id', 'like', $id)->first();

        $product = $this->findById(Product::class, $id);

        ++$product->amount;
        $product->save();
        $selected_product->delete();

        return self::success('product deleted from user cart');
    }
}
