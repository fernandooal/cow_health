<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Collar>
 */
class CollarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'status' => $this->faker->randomElement(['ok', 'manutencao', 'bateria', 'inativo']),
            'data_frequency' => $this->faker->randomElement(['2', '10', '60']),
        ];
    }
}
