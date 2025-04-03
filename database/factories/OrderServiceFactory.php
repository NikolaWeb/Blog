<?php

namespace Database\Factories;

use App\Models\OrderService;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderServiceFactory extends Factory
{
    protected $model = OrderService::class;
    protected $counter = 11;

    public function definition()
    {
        return [
            'substation_id' => $this->counter, // Hardcoded vrednost
            'substation_name' => 'Servis Trafostanica ' . $this->counter,
            'substation_code' => 10000 + $this->counter++,
            'gps' => '44.7866, 20.4489', // Random GPS koordinata za Beograd
            'gsm_signal_strength' => 75, // Hardcoded vrednost
            'signal_score' => 5, // Hardcoded vrednost
            'sequence' => 1,
            'nfc_lock_id' => 2, // Hardcoded vrednost
            'battery_replaced' => 0, // Default vrednost
            'sim_replaced' => 1, // Sim kartica zamenjena
            'power_supply_replaced' => 0, // Napajanje nije zamenjeno
            'comment' => 'Test order service comment', // Hardcoded komentar
            'planned_order_date' => now(),
            'order_status' => $this->faker->randomElement(config('blog.config_order_status', ['za_slanje'])),
            'order_created_by' => 1,
            'order_created_at' => now(),
            'user_id' => 3,
            'order_completed_at' => now(),
            'inspected_by' => 2,
            'inspected_at' => now(),
            'active' => 1, // Aktivno
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
