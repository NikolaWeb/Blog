<?php

namespace Database\Factories;

use App\Models\OrderSubstationScan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;

class OrderSubstationScanFactory extends Factory
{
    protected $model = OrderSubstationScan::class;
    private static int $counter = 1;

    public function definition()
    {
        return [
            'substation_id' => self::$counter, // Hardcoded vrednost
            'substation_name' => 'Skeniranje Trafostanica ' . self::$counter,
            'substation_code' => 10000 + self::$counter++,
            'gps' => '44.7866, 20.4489', // Random GPS koordinata za Beograd
            'gsm_signal_strength' => 75, // Hardcoded vrednost
            'signal_score' => 5, // Hardcoded vrednost
            'sequence' => 1,
            'voltage_level' => '220V',
            'door_orientiation' => 'East',
            'door_count' => 2,
            'metalwork_nedded' => 0,
            'comment' => 'Initial scan completed', // Hardcoded komentar
            'planned_order_date' => now(),
            'order_status' => $this->faker->randomElement(config('blog.config_order_status', ['za_slanje'])),
            'order_created_by' => 1,
            'order_created_at' => now(),
            'user_id' => 3,
            'order_completed_at' => null,
            'inspected_by' => null,
            'inspected_at' => null,
            'active' => 1, // Aktivno
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
