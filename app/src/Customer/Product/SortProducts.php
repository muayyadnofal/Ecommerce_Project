<?php

namespace App\src\Customer\Product;

use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Traits\HttpTraits\HttpResponse;

class SortProducts
{
    use HttpResponse;
    public function sortProducts($request): \Illuminate\Http\Response
    {
        // get the products to sort
        $query = Product::query();

        // requesting __sort by && __sort input desc or
        $sortBy = $request->input('sortBy');
        if ($sort = $request->input('sort')) {
            $query->orderBy($sortBy, $sort);
        }

        // get products after ordering
        $products = $query->get();

        // handled response for products
        return self::returnData('products', ProductResource::collection($products), "Products ordered by {$sortBy} successfully");
    }
}
