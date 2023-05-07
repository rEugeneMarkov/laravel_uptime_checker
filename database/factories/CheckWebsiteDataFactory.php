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
            'website_id' => Website::get()->random()->id,
            'response_status' => 200,
            'execution_time' => fake()->numberBetween(1, 5),
            'checked_at' => fake()->dateTimeBetween('-1 day', '+0 day'),
        ];
    }
}
