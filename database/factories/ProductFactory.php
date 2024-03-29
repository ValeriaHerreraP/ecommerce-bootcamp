<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
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
                'product' => fake()->name(),
                'price' => mt_rand(25000, 300000),
                'description' => fake()->sentence(),
                'image' => 'images/logo.png',
                'state' => true,

            ];
    }
}
