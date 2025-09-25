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

        // --- Buat user ---
        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@gmail.com',
        ]);

        // Assign role user dari ShieldSeeder
        $userRole = Role::where('name', 'user')->first();
        if ($userRole) {
            $user->assignRole($userRole);
        }

        // --- Optional: buat beberapa user random tanpa role ---
        // User::factory(5)->create();
    }
}
