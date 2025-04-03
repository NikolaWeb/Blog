<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\blog>
 */
class blogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lock_code' => random_int(100000, 999999),
            'electronic_unit' => random_int(100000, 999999),
            'gsm' => $this->faker->phoneNumber(),
            'gsm_sn' => random_int(100000, 999999),
        ];
    }
}
