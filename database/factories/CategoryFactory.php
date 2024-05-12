<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = ['Electronics', 'Clothing', 'Books', 'Toys', 'Furniture', 'Food', 'Tools', 'Sporting Goods', 'Automotive', 'Jewelry', 'Health & Beauty', 'Music', 'Movies', 'Games', 'Pet Supplies', 'Office Supplies', 'Home Goods', 'Garden', 'Baby', 'Industrial', 'Arts & Crafts', 'Collectibles', 'Other'];
        return [
            'name' => $this->faker->unique()->randomElement($category),
            'description' => $this->faker->text
        ];
    }
}
