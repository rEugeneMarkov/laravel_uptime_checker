<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Website>
 */
class WebsiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'email' => fake()->email(),
            'website' => fake()->DomainName(),
            'user_id' => fake()->numberBetween(1, 5),
            'interval' => fake()->numberBetween(1, 5),
            'timeout' => fake()->numberBetween(5, 60),
        ];
    }
}
