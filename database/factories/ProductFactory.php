<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            //name owner
            'name_owner' => fake()->name(),
            //contact
            'no_kontak' => fake()->numberBetween(12),
            //price
            'price' => fake()->randomNumber(4),
            'description' => fake()->text(),
            'stock' => fake()->randomNumber(2),
            'longitude' => fake()->longitude(),
            'latitude' => fake()->latitude(),
            'image' => fake()->imageUrl(),
            'category_id' => fake()->numberBetween(1, 4),
        ];
    }
}
