<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\categoriesRequest;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\src\Customer\Product\FilterProducts;
use App\src\Customer\Product\SearchProducts;
use App\src\Customer\Product\SortProducts;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function store(ProductRequest $request, $categoryName): \Illuminate\Http\Response
    {
        return (new \App\src\Seller\Product\CreateProduct)->createProduct($request, $categoryName);
    }

    public function destroy($id): \Illuminate\Http\Response
    {
        return (new \App\src\Seller\Product\DeleteProduct)->deleteProduct($id);
    }

    public function update(ProductUpdateRequest $request, $id): \Illuminate\Http\Response
    {
        return (new \App\src\Seller\Product\UpdateProduct)->editProduct($request, $id);
    }

    public function getAllProducts(): \Illuminate\Http\Response
    {
        return (new \App\src\Customer\Product\GetProducts)->getAllProducts();
    }

    public function getProduct($id): \Illuminate\Http\Response
    {
        return (new \App\src\Customer\Product\GetProducts)->getProduct($id);
    }

    public function getCategoryProducts(CategoriesRequest $request): \Illuminate\Http\Response
    {
        return (new \App\src\Customer\Product\GetProducts)->getCategoryProducts($request);
    }

    public function filter(Request $request): \Illuminate\Http\Response
    {
        return (new \App\src\Customer\Product\FilterProducts)->filterProducts($request);
    }

    public function sort(Request $request): \Illuminate\Http\Response
    {
        return (new \App\src\Customer\Product\SortProducts)->sortProducts($request);
    }

    public function search(Request $request): \Illuminate\Http\Response
    {
        return (new \App\src\Customer\Product\SearchProducts)->search($request);
    }
}
