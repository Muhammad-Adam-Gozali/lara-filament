<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\User;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Widgets\StatsOverviewWidget\Stat;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      $this->call([
          CountrySeeder::class,
        StateSeeder::class,
        CitySeeder::class,
        UserSeeder::class,
        DepartmentSeeder::class,
        EmployeeSeeder::class,
      ]);
    }
}
