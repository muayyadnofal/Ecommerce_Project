<?php

namespace App\Http\Resources\Profile\Admin;

use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Review\ReviewResource;
use App\Models\Admin;
use App\Models\Product;
use App\Traits\EloquentTraits\Find;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminProfileResource extends JsonResource
{
    use Find;

    // get all reviews for product __comments  & stars & likes
    public function getProducts($id): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $admin = $this->findById(Admin::class, $id);
        return ProductResource::collection($admin->products);
    }

    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone number' => $this->number,
            'address' => $this->address,
            'products' => $this->getProducts($this->id)
        ];
    }
}
