<?php

namespace App\src\Customer\Comment;

use App\Http\Resources\Comment\CommentsResource;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use App\Traits\AuthTraits\GetUser;
use App\Traits\EloquentTraits\Create;
use App\Traits\HttpTraits\HttpResponse;

class AddComment
{
    use HttpResponse;
    use GetUser;
    use Create;

    public function addComment($id, $request): \Illuminate\Http\Response
    {
        $user = $this->getAuthenticatedUser(User::class);

        $product = $this->findById(Product::class, $id);
        if(!$product) {
            return self::failure('product does not exist');
        }

        $comment = new Comment($request->all());
        $comment['customer'] = $user->name;
        $comment['user_id'] = $user->id;
        $comment['product_id'] = $product->id;
        $comment->save();
        $product->comments()->save($comment);

        return self::returnData('comment', new CommentsResource($comment), "comment add successfully to product {$product->name}");
    }
}
