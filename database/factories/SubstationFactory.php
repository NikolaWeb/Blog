<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Substation>
 */
class SubstationFactory extends Factory
{
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private static int $index = 1;
    private static int $counter = 1;
    private static int $branchCounter = 1;

    public function definition(): array
    {
        $latBase = '44.6';
        $lonBase = '21.1';
    
        $latitude = $this->faker->randomFloat(7, 44.5000000, 44.7000000); 
        $longitude = $this->faker->randomFloat(7, 21.2000000, 21.3000000);
    
        return [
            'name' => 'Trafostanica ' . self::$counter,
            'branch_id' => intdiv(self::$counter - 1, 3) + 1,
            'substation_code' => 10000 + self::$counter,
            'nfc_lock_id' => self::$counter,
            'address' => 'adresa ' . self::$counter++,
            'gps' => $latitude . ',' . $longitude,
            'gsm_signal_strength' => $this->faker->numberBetween(0, 100),
            'signal_score' => $this->faker->numberBetween(0, 100),
            'substation_status' => $this->faker->randomElement(config('blog.config_substation_status', ['za_montazu'])),
            'type' => $this->faker->randomElement(['type1', 'type2', 'type3']),
            'voltage_level' => $this->faker->randomElement(['low', 'medium', 'high']),
            'door_orientation' => $this->faker->randomElement(['north', 'south', 'east', 'west']),
            'door_count' => $this->faker->numberBetween(1, 5),
            'number_of_microswitches' => $this->faker->numberBetween(1, 10),
            'nfc_lock_type' => $this->faker->randomElement(['typeA', 'typeB', 'typeC']),
            'comment' => $this->faker->text,
            'user_comment' => $this->faker->text,
            'metalwork_needed' => $this->faker->boolean,
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    
}
