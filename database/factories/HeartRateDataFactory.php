<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HeartRateData>
 */
class HeartRateDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cow_id' => $this->faker->randomElement([1, 2]),
            'bpm' => $this->faker->numberBetween(60, 120),
        ];
    }
}
