<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $admin =config('blog.config_user_types.admin');

        User::factory()->create([
            'name' => 'admin',
            'password' => 'admin',
            'type' => config('blog.config_user_types.admin')
        ]);

        User::factory()->create([
            'name' => 'korisnik',
            'password' => 'korisnik',
            'type' => config('blog.config_user_types.user')
        ]);
        User::factory()->create([
            'name' => 'milos',
            'password' => 'milos',
            'type' => config('blog.config_user_types.bloger')
        ]);
        User::factory()->create([
            'name' => 'emil',
            'password' => 'emil',
            'type' => config('blog.config_user_types.bloger')
        ]);
    }
}
