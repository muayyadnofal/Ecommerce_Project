<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Comment\CommentsResource;
use App\Http\Resources\Review\ReviewResource;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Like;
use App\Models\Product;
use App\Models\User;
use App\Traits\DatesTraits\CompareDates;
use App\Traits\EloquentTraits\Find;
use App\Traits\ProductTraits\DeleteByDate;
use App\Traits\ProductTraits\Price;
use App\Traits\ProductTraits\UploadImage;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductResource extends JsonResource
{
    use UploadImage;
    use DeleteByDate;
    use Price;
    use Find;

    // get the category name __ to insert category name to product response
    public function getCategoryName($id)
    {
        return $this->findById(Category::class, $id)->name;
    }

    // get all reviews for product __comments  & stars & likes
    public function getReviews($id): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $product = $this->findById(Product::class, $id);
        return ReviewResource::collection($product->reviews);
    }

    // get all comments
    public function getComments($id): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $product = $this->findById(Product::class, $id);
        return CommentsResource::collection($product->comments);
    }

    // get how many likes on product
    public function countLikes($id) {
        $product = $this->findById(Product::class, $id);
        return $product->likes()->get()->count();
    }

    // get liked by users names
    public function getUsersNames($id) {
        $names = [];
        $v = [];
        $users = DB::table('likes')->where('product_id', 'like', $id)->get('user_id');
        foreach($users as $user) {
            $names[] = DB::table('users')->where('id', 'like', $user->user_id)->pluck('name');
        }
        return $names;
    }

    // getting the product owner info
    public function getContactInfo($id): array
    {
        $seller = $this->findById(Admin::class, $id);
        return [
            $seller->number,
            $seller->address,
        ];
    }

    public function checkExpiration($expiration, $id): bool
    {
        if (!$this->delete($expiration, $id)) {
            return false;
        }
        return true;
    }

    public function toArray($request)
    {
        if ($this->checkExpiration($this->expiration, $this->id)) {
            return ;
        }
        return [
            'expiration_date' => $this->expiration,
            'id' => $this->id,
            'image' => $this->image,
            'name' => $this->name,
            'category' => $this->getCategoryName($this->category_id),
            'description' => $this->detail,
            'totalPrice' => $this->modifyPrice($this->price, $request),
            'views' => $this->views,
            'likes' => $this->countLikes($this->id),
            'liked by' => $this->getUsersNames($this->id),
            'amount' => $this->amount,
            'rating' => $this->reviews->count() > 0 ?
                round($this->reviews->sum('star') / $this->reviews->count()) : 0,
            'discounts' => [
                'first discount' => "the price for product {$this->name} will be discounted by {$this->discount_1} percent in {$this->date_1}",
                'second discount' => "the price for product {$this->name} will be discounted by {$this->discount_2} percent in {$this->date_2}",
                'third discount' => "the price for product {$this->name} will be discounted by {$this->discount_3} percent in {$this->date_3}",
            ],
            'seller contact info' => [
                'phone number' => $this->getContactInfo($this->admin_id)[0],
                'address' => $this->getContactInfo($this->admin_id)[1],
            ],
            'comments' => $this->getComments($this->id),
            'reviews' => $this->getReviews($this->id),
        ];
    }
}
