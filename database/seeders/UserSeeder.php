<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // --- Buat superadmin ---
        $superadmin = User::factory()->create([
            'name' => 'Superadmin',
            'email' => 'superadmin@gmail.com',
        ]);

        // Assign role super_admin dari ShieldSeeder
        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($superAdminRole) {
            $superadmin->assignRole($superAdminRole);
        }

        // --- Buat user1 ---
        $user1 = User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com',
        ]);

        // Assign role user1 dari ShieldSeeder
        $user1Role = Role::where('name', 'user1')->first();
        if ($user1Role) {
            $user1->assignRole($user1Role);
        }

        // --- Optional: buat beberapa user random tanpa role ---
        // User::factory(5)->create();
    }
}
