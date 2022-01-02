<?php

namespace App\src\shared\Product;

use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Traits\EloquentTraits\Find;
use App\Traits\HttpTraits\HttpResponse;
use Illuminate\Support\Carbon;

class ShowProduct
{
    use Find;
    use HttpResponse;
    public function showProduct($id)
    {
        $product = $this->findById(Product::class, $id);
        return self::returnData('product', new ProductResource($product), 'dd');
    }
}
