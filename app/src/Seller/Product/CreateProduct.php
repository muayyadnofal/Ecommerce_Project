<?php

namespace App\src\Seller\Product;

use App\Http\Resources\Product\ProductResource;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Traits\EloquentTraits\Create;
use App\Traits\EloquentTraits\Find;
use App\Traits\HttpTraits\HttpResponse;
use App\Traits\ProductTraits\UploadImage;
use Illuminate\Support\Facades\Auth;

class CreateProduct
{
    use HttpResponse;
    use Create;
    use Find;
    use UploadImage;

    public function createProduct($request, $categoryName): \Illuminate\Http\Response
    {
        // get the authenticated admin
        $seller_id = Auth::user()->id;
        $seller = $this->findById(Admin::class, $seller_id);

        // get category by its id
        $category = $this->findByName('categories', 'name', $categoryName);
        if (!$category) {
            return self::failure("category {$categoryName} not found");
        }

        // create the product and save it to the ordered category __&save it to seller products
        $product = new Product($request->all());
        $product['image'] = $this->upload($request->image);
        $product['admin_id'] = $seller->id;
        $product['category'] = $category->name;
        $category->products()->save($product);
        $seller->products()->save($product);

        return self::returnData('product', new ProductResource($product), 'product created successfully');
    }
}
