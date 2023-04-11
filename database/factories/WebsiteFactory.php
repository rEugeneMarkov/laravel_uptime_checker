<?php

namespace Database\Factories;

use App\Models\Frequency;
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
            'user_id' => User::get()->random()->id,
            'frequency_id' => 1,
            //'frequency_id' => Frequency::get()->random()->id,
        ];
    }
}
