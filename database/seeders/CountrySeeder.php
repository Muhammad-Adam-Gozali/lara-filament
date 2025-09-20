<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->delete();
        $countries = [
            ['code' => 'IN', 'name' => "India", 'phonecode' => 91],
            ['code' => 'AF', 'name' => "Afghanistan", 'phonecode' => 93],
            ['code' => 'PK', 'name' => "Pakistan", 'phonecode' => 92],
            ['code' => 'NP', 'name' => "Nepal", 'phonecode' => 977],
            ['code' => 'BD', 'name' => "Bangladesh", 'phonecode' => 880],
            ['code' => 'LK', 'name' => "Sri Lanka", 'phonecode' => 94],
            ['code' => 'BT', 'name' => "Bhutan", 'phonecode' => 975],
            ['code' => 'MM', 'name' => "Myanmar", 'phonecode' => 95],
            ['code' => 'MV', 'name' => "Maldives", 'phonecode' => 960],
            ['code' => 'CN', 'name' => "China", 'phonecode' => 86],
        ];
        DB::table('countries')->insert($countries);
    }
}
