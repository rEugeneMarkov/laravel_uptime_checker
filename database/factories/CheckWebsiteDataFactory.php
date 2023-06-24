<?php

namespace Database\Factories;

use App\Models\Website;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CheckWebsiteData>
 */
class CheckWebsiteDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'website_id' => fake()->numberBetween(1, 100),
            'response_status' => fake()->randomElement([200, 404, 500]),
            'execution_time' => fake()->numberBetween(1000, 5000),
            'checked_at' => fake()->dateTimeBetween('-2 day'),
        ];
    }
}
