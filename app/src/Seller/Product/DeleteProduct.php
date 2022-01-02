<?php

namespace App\src\Seller\Product;

use App\Models\Admin;
use App\Models\Product;
use App\Traits\AuthTraits\CheckID;
use App\Traits\AuthTraits\GetUser;
use App\Traits\EloquentTraits\Find;
use App\Traits\HttpTraits\HttpResponse;

class DeleteProduct
{
    use HttpResponse;
    use CheckID;
    use GetUser;
    use Find;

    public function deleteProduct($id): \Illuminate\Http\Response
    {
        // get the seller info
        $seller = $this->getAuthenticatedUser(Admin::class);

        // find the product by its id to delete
        $product = $this->findById(Product::class, $id);
        if (!$product || !$this->checkAdminID($product, $seller)) {
            return self::failure('product does not belong to you');
        }

        // delete the product if found
        $product->delete();

        // return handled successful message
        return self::success('product deleted successfully');
    }
}
