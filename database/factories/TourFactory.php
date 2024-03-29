<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $startingDate = now()->addDays(rand(1, 50));
        $endingDate = now()->addDays(rand(51, 70));

        return [
            'travel_id' => 'TEST',
            'name' => fake()->text(20),
            'starting_date' => $startingDate,
            'ending_date' => $endingDate,
            'price' => fake()->randomFloat(2, 25, 999),
        ];
    }
}
