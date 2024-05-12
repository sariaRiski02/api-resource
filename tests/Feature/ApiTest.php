<?php

namespace Tests\Feature;

use App\Http\Resources\CategorySimpleResource;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_API(): void
    {
        $category = Category::first();
        $this->get("/api/categories/$category->id")
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description
                ],
            ]);
    }

    public function test_API_Colections()
    {
        $category = Category::all();
        $resultCategory = $category->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description
            ];
        });
        // dd($resultCategory);
        // dd($category->toArray());
        $this->get('/api/categories')
            ->assertStatus(200)
            ->assertJson([
                'data' => $resultCategory->toArray()
            ]);

        // dd($category->toJson());
    }

    public function test_API_collection_custom()
    {
        $category = Category::all();
        $this->get('/api/collection')
            ->assertStatus(200)
            ->assertJson(
                [
                    'data' => $category->toArray(),
                    'total' => count($category->toArray())
                ]
            );
    }

    public function test_API_nested()
    {

        $allCategories = Category::all();
        $result = $allCategories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name
            ];
        });

        $this->get('/api/nested-simple-categories')
            ->assertStatus(200)
            ->assertJson(
                [
                    'data' => $result->toArray(),
                    'total' => count($result)
                ]
            );
    }

    public function test_API_warp()
    {
        $product = Product::first();

        $dataProduct = [
            'id' => $product->id,
            'name' => $product->name,
            'category' => [
                'id' => $product->category->id,
                'name' => $product->category->name
            ],
            'created_at' => $product->created_at->toJson(),
            'updated_at' => $product->updated_at->toJson()
        ];

        // dd($dataProduct);
        $this->get("/api/product/$product->id")
            ->assertStatus(200)
            ->assertJson(
                [
                    'values' => $dataProduct
                ]
            );
    }


    public function test_API_warp_collection()
    {
        $this->get('/api/products')
            ->assertStatus(200)
            ->assertJson([
                'values' => [
                    'data' => Product::all()->toArray(),
                    'total' => Product::all()->count()
                ]
            ]);
    }

    public function test_API_pagination()
    {
        $resoponse = $this->get('/api/pagination')
            ->assertStatus(200);

        self::assertNotNull($resoponse->json('values.data'));
        self::assertNotNull($resoponse->json('values.total'));
        self::assertNotNull($resoponse->json('links'));
        self::assertNotNull($resoponse->json('meta'));
    }

    public function test_Additional_data()
    {
        $product = Product::first();
        $this->get("/api/product-debug/$product->id")
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price
                ],
                'meta' => 'additional data'
            ]);
    }

    public function test_API_condition()
    {
        $product = Product::first();
        $this->get("/api/product-condition/$product->id")
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'is_expensive' => $product->price > 100 ?? false,
                    'created_at' => $product->created_at->toJson(),
                    'updated_at' => $product->updated_at->toJson()
                ]
            ]);
    }

    public function test_API_condition_loadedData()
    {
        $product = Product::first();
        $this->get("/api/product-condition-load/$product->id")
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => [
                        'id' => $product->category->id,
                        'name' => $product->category->name
                    ],
                    'price' => $product->price,
                    'is_expensive' => $product->price > 100,
                    'created_at' => $product->created_at->toJson(),
                    'updated_at' => $product->updated_at->toJson()
                ]
            ]);

        // dd($product->created_at);
    }

    public function test_API_response()
    {
        $product = Product::first();
        $this->get("/api/product/$product->id")
            ->assertStatus(200)
            ->assertHeader('X-Value', 'TestResponseResource');
    }
}
