<?php

namespace App\src\Seller\Product;

use App\Http\Resources\Product\ProductResource;
use App\Models\Admin;
use App\Models\Product;
use App\Traits\AuthTraits\CheckID;
use App\Traits\AuthTraits\GetUser;
use App\Traits\EloquentTraits\Create;
use App\Traits\EloquentTraits\Find;
use App\Traits\HttpTraits\HttpResponse;
use App\Traits\ProductTraits\UploadImage;
use Illuminate\Support\Facades\Auth;

class UpdateProduct
{
    use HttpResponse;
    use CheckID;
    use UploadImage;
    use GetUser;
    use Find;
    use Create;

    public function editProduct($request, $id): \Illuminate\Http\Response
    {
        // get the seller info
        $seller = $this->getAuthenticatedUser(Admin::class);

        // find the product by its id
        $product = $this->findById(Product::class, $id);
        if (!$product || !$this->checkAdminID($product, $seller)) {
            return self::failure('product does not belong to seller');
        }

        $product->update($request->all());
        $product['image'] = $this->upload($request->image);
        $product->save();

        // return handled response for updating a product info
        return self::returnData('product', new ProductResource($product), 'product updated successfully');
    }
}
