<?php

namespace App\src\Customer\Product;

use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Traits\HttpTraits\HttpResponse;

class SearchProducts
{
    use HttpResponse;

    public function search($request): \Illuminate\Http\Response
    {
        // defining the request input type
        $category = $request->input('category');
        $product_name = $request->input('name');
        $expiration_date = $request->input('expiration');

        // defining the product query
        $query = Product::query();

        // search by category name
        if ($category) {
            $query->where('category', 'like', $category);
        }

        // search by product name
        if ($product_name) {
            $query->where('price', 'like',  $product_name);
        }

        // search by product expiration date
        if ($expiration_date) {
            $query->where('expiration', 'like', $expiration_date);
        }

        // get products after searching
        $products = $query->get();
        if ($products->isEmpty()) {
            return self::failure('no products found');
        }

        // handled response for products
        return self::returnData('products', ProductResource::collection($products), 'done searching');
    }
}
