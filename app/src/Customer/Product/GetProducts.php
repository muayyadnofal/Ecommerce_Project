<?php

namespace App\src\Customer\Product;

use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Models\User;
use App\Models\View;
use App\Traits\AuthTraits\GetUser;
use App\Traits\EloquentTraits\Create;
use App\Traits\EloquentTraits\Find;
use App\Traits\HttpTraits\HttpResponse;
use Illuminate\Support\Facades\DB;

class GetProducts
{
    use HttpResponse;
    use Find;
    use Create;
    use GetUser;

    // get all products
    public function getAllProducts(): \Illuminate\Http\Response
    {
        $products = Product::all();
        return self::returnData('Products', ProductResource::collection($products), 'all products');
    }

    // get product by its id
    public function getProduct($id): \Illuminate\Http\Response
    {
        // get the authenticated user info
        $user = $this->getAuthenticatedUser(User::class);

        // find the product and check if exists
        $product = $this->findById(Product::class, $id);
        if (!$product) {
            return self::failure('product not found');
        }

        // get all user id who view the product
        $viewBy = View::all();

        // check if user already saw this product
        $exist = $viewBy->where('user_id', 'like', $user->id)->first();

        // increment the number of views
        if(!$exist) {
            $product->increment('views');
            DB::table('views')->insert(['user_id'=>$user->id]);
        }

        // return handled product data
        return self::returnData('product', new ProductResource($product), "Product {$id} found");
    }

    // get category products
    public function getCategoryProducts($request): \Illuminate\Http\Response
    {
        // requesting the category name
        $name = $request->input('name');

        // get category and check if exists
        $category = $this->findByName('categories', 'name', $name);
        if (!$category) {
            return self::failure("category {$name} not found");
        }

        // get all products from this category
        $products = $category->products;
        if (!$products) {
            return self::failure("no products for category {$name}");
        }

        // return handled data for category products
        return self::returnData('products',  ProductResource::collection($products), "all category {$name} products here");
    }
}
