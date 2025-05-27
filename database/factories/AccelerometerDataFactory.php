<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccelerometerData>
 */
class AccelerometerDataFactory extends Factory
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
            'gyro_x' => $this->faker->randomFloat(2, -10, 10),
            'gyro_y' => $this->faker->randomFloat(2, -10, 10),
            'gyro_z' => $this->faker->randomFloat(2, -10, 10),
            'accel_x' => $this->faker->randomFloat(2, -10, 10),
            'accel_y' => $this->faker->randomFloat(2, -10, 10),
            'accel_z' => $this->faker->randomFloat(2, -10, 10),
        ];
    }
}
