<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(['HR', 'Finance', 'IT', 'Marketing', 'Sales', 'Operations', 'Customer Service', 'R&D', 'Legal', 'Admin'])
            ->each(fn($department) => Department::query()->create(['name' => $department]));
    }
}
