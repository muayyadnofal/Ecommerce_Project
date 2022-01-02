<?php


use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Product\ProductsController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Review\ReviewsController;
use Illuminate\Support\Facades\Route;

// ************************ login __ register __ logout ************************** //
// admin login and register routes
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    // admin login
    Route::post('/login', [AdminController::class, 'login']);
    // admin register
    Route::post('/register', [AdminController::class, 'register']);
});

// user login and register routes
Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
    // user login
    Route::post('/login', [UserController::class, 'login']);
    //user register
    Route::post('/register', [UserController::class, 'register']);
});

// user & admin logout
Route::group(['prefix' => 'auth', 'middleware' => ['auth.guard:admin_api', 'auth.guard:user_api']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
// *************************************************************************************

// ************************ admin roles for Product ************************** //
Route::group(['prefix' => 'admin/product', 'middleware' => ['auth.guard:admin_api', 'protected']], function () {
    //create product
    Route::post('/create/{categoryName}', [ProductsController::class, 'store']);
    Route::delete('/delete/{id}', [ProductsController::class, 'destroy']);
    Route::post('/update/{id}', [ProductsController::class, 'update']);
});
// *************************************************************************************

// ************************ admin profile ************************** //
Route::group(['prefix' => 'admin', 'middleware' => ['auth.guard:admin_api', 'protected']], function () {
    //get admin profile
    Route::get('/profile', [ProfileController::class, 'getAdminProfile']);
});
// *************************************************************************************



// ************************ user roles for Product ************************** //
Route::group(['prefix' => 'user/product', 'middleware' => ['auth.guard:user_api', 'protected']], function () {
    // get all products
    Route::get('/getAll', [ProductsController::class, 'getAllProducts']);
    // get product
    Route::get('/getAll/{id}', [ProductsController::class, 'getProduct']);
    // get all category products
    Route::get('/category/getAll', [ProductsController::class, 'getCategoryProducts']);
    // filter products
    Route::get('/filter', [ProductsController::class, 'filter']);
    // sort products
    Route::get('/sort', [ProductsController::class, 'sort']);
    // search for products
    Route::get('/search', [ProductsController::class, 'search']);
});
// *************************************************************************************

// ************************ user roles for Reviews ************************** //
Route::group(['prefix' => 'user/review', 'middleware' => ['auth.guard:user_api', 'protected']], function () {
    // make a review
    Route::post('/create/{id}', [ReviewsController::class, 'store']);
});
// *************************************************************************************

// ************************ user roles for cart ************************** //
Route::group(['prefix' => 'user/cart', 'middleware' => ['auth.guard:user_api', 'protected']], function () {
    // add product to cart
    Route::get('/add', [\App\Http\Controllers\Cart\cartsController::class, 'store']);
    // add product to cart __no amount
    Route::get('/addOne', [\App\Http\Controllers\Cart\cartsController::class, 'storeOne']);
    // get cart products
    Route::get('/getAll', [\App\Http\Controllers\Cart\cartsController::class, 'getProducts']);
    // delete product from cart
    Route::delete('/delete', [\App\Http\Controllers\Cart\cartsController::class, 'delete']);
});
// *************************************************************************************
