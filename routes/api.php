<?php

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\WarpDataCollection;
use App\Http\Resources\CategoriesCollection;
use App\Http\Resources\ProductDebugResource;
use App\Http\Resources\CategoryNestedResource;
use App\Http\Resources\ProductConditionResource;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/categories/{id}', function ($id) {
    $category = Category::findOrfail($id);
    return new CategoryResource($category);
});

Route::get('/categories', function () {
    $allCategories = Category::all();
    return CategoryResource::collection($allCategories);
});

Route::get('/collection', function () {
    $collection = Category::all();
    return new CategoriesCollection($collection);
});

Route::get('/nested-simple-categories', function () {
    $allCategories = Category::all();
    return new CategoryNestedResource($allCategories);
});

Route::get('/product/{id}', function ($id) {
    $product = Product::find($id);
    return new ProductResource($product);
});


Route::get('/products', function () {
    $products = Product::all();
    return new WarpDataCollection($products);
});


Route::get('/pagination', function () {
    $products = Product::paginate(2);
    return new WarpDataCollection($products);
});

Route::get('/product-debug/{id}', function ($id) {
    $product = Product::find($id);
    return new ProductDebugResource($product);
});

Route::get('/product-condition/{id}', function ($id) {
    $product = Product::find($id);

    return new ProductConditionResource($product);
});

Route::get('/product-condition-load/{id}', function ($id) {
    $product = Product::find($id);
    $product->load('category');
    return new ProductConditionResource($product);
});
