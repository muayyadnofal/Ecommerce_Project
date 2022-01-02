<?php

namespace App\src\Customer\Reviews;

use App\Http\Resources\Review\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Traits\AuthTraits\GetUser;
use App\Traits\EloquentTraits\Find;
use App\Traits\HttpTraits\HttpResponse;

class CreateReview
{
    use HttpResponse;
    use Find;
    use GetUser;

    public function makeReview($request, $id): \Illuminate\Http\Response
    {
        // get authenticated user
        $user = $this->getAuthenticatedUser(User::class);

        // get the product if exist
        $product = $this->findById(Product::class, $id);
        if (!$product) {
            return self::failure("product {$id} not found");
        }

        // create the review
        $review = new Review($request->all());
        $review['customer'] = $user->name;
        $product->reviews()->save($review);

        // return handled review data
        return self::returnData('review', new ReviewResource($review), 'review posted successfully');
    }
}
