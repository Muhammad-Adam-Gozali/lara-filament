<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // jalankan factory -> bikin 10 user random
        // User::factory(10)->create();

        // bikin user spesial (misalnya admin)
        User::factory()->create([
            'name' => 'Superadmin',
            'email' => 'admin@example.com',
        ]);
    }
}
