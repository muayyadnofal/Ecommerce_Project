<?php

namespace App\src\Customer\Like;

use App\Models\Product;
use App\Models\User;
use App\Traits\AuthTraits\GetUser;
use App\Traits\EloquentTraits\Create;
use App\Traits\EloquentTraits\Find;
use App\Traits\HttpTraits\HttpResponse;

class Like
{
    use HttpResponse;
    use GetUser;
    use Find;
    use Create;

    public function likeAndDislike($id): \Illuminate\Http\Response
    {
        $user = $this->getAuthenticatedUser(User::class);

        $product = $this->findById(Product::class, $id);
        if(!$product) {
            return self::failure('product does not exist');
        }

        $likes = \App\Models\Like::all();

        $selected = $likes->where('user_id', 'like', $user->id)
            ->where('product_id', '=', $product->id)->first();

        if ($selected) {
            $selected->delete();
            return self::success("{$user->name} unlike product {$product->name}");
        }

        $request = [
            $user->id,
            $product->id
        ];

        $like = \App\Models\Like::create([
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);
        $product->likes()->save($like);
        $user->likes()->save($like);

        return self::success("{$user->name} likes product {$product->name}");
    }
}
