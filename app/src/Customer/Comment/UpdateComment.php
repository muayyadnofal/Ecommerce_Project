<?php

namespace App\src\Customer\Comment;

use App\Http\Resources\Comment\CommentsResource;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use App\Traits\AuthTraits\GetUser;
use App\Traits\EloquentTraits\Find;
use App\Traits\HttpTraits\HttpResponse;

class UpdateComment
{
    use HttpResponse;
    use GetUser;
    use Find;

    public function editComment($request, $product_id, $comment_id): \Illuminate\Http\Response
    {
        $user = $this->getAuthenticatedUser(User::class);

        $product = $this->findById(Product::class, $product_id);
        if(!$product) {
            return self::failure('product does not exist');
        }

        $comments = Comment::all();

        $comment = $comments->where('user_id', 'like', $user->id)
            ->where('product_id', 'like', $product->id)->first();

        if (!$comment) {
            return self::failure('comment does not belong to user');
        }

        $comment->update($request->all());

        return self::returnData('comment', new CommentsResource($comment), 'comment edited successfully');
    }
}
