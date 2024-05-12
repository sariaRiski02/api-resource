<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JointableTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testJoin(): void
    {
        $join = Product::find(1)->category;
        $this->assertNotNull($join);
    }
}
