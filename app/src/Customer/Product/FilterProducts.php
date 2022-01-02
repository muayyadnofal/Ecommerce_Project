<?php

namespace App\src\Customer\Product;

use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Traits\HttpTraits\HttpResponse;

class FilterProducts
{
    use HttpResponse;

    public function filterProducts($request): \Illuminate\Http\Response
    {
        // defining the request input type
        $category = $request->input('category');
        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');

        // defining the product query
        $query = Product::query();

        // search by category name
        if ($category) {
            $query->where('category', 'like', $category);
        }

        // search by price range
        if ($min_price && $max_price) {
            $query->where('price', '>=', $min_price)
            ->where('price', '<=', $max_price);
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
