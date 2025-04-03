<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderInstallationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private $counter = 5;
    
    public function definition(): array
    {
        return [
            'substation_id' => $this->counter, // Hardcoded vrednost
            'substation_name' => 'Instalacija Trafostanica ' . $this->counter,
            'substation_code' => 10000 + $this->counter++,
            'gps' => '44.7866, 20.4489', // Random GPS koordinata za Beograd
            'gsm_signal_strength' => 75, // Hardcoded vrednost
            'signal_score' => 5, // Hardcoded vrednost
            'sequence' => 1,
            'nfc_lock_id' => 2, // Hardcoded vrednost
            'number_of_microswitches' => 3,
            'comment' => 'Test order installation comment', // Hardcoded vrednost
            'planned_order_date' => now(),
            'order_status' => $this->faker->randomElement(config('blog.config_order_status', ['za_slanje'])),
            'order_created_by' => 1,
            'order_created_at' => now(),
            'user_id' => 3,
            'order_completed_at' => now(),
            'inspected_by' => 1,
            'inspected_at' => now(),
            'active' => 1, // Default aktivno
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
