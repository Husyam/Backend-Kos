<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;


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
            'category_gender' => fake()->randomElement(['Laki-laki', 'Perempuan', 'Campuran']),
            //price
            'price' => fake()->randomNumber(4),
            'description' => fake()->text(),
            // 'fasilitas' => fake()->randomElement(['AC', 'Wifi', 'Kulkas', 'TV', 'Kamar Mandi', 'smoking area']), data berupa array
            'fasilitas' => json_encode(['AC', 'Wifi', 'Kulkas', 'TV', 'Kamar Mandi', 'smoking area']),
            'stock' => fake()->randomNumber(2),
            'address' => fake()->address(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'image' => fake()->imageUrl(),
            'multi_image' => json_encode([fake()->imageUrl(), fake()->imageUrl(), fake()->imageUrl()]),
            'id_category' => fake()->numberBetween(1, 4),


        ];
    }
}
