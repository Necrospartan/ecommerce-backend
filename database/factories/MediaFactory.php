<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'location' => fake()->randomElement(['CDMX', 'GDL', 'MTY', 'MOR']),
            'type' => fake()->randomElement(['billboard', 'digital', 'transit']),
            'image' => null,
            'price_per_day' => fake()->randomFloat(2, 10, 500),
        ];
    }
}
