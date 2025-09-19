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
    ['id' => 101, 'code' => 'IN', 'name' => "India", 'phonecode' => 91],
    ['id' => 102, 'code' => 'AF', 'name' => "Afghanistan", 'phonecode' => 93],
    ['id' => 103, 'code' => 'PK', 'name' => "Pakistan", 'phonecode' => 92],
    ['id' => 104, 'code' => 'NP', 'name' => "Nepal", 'phonecode' => 977],
    ['id' => 105, 'code' => 'BD', 'name' => "Bangladesh", 'phonecode' => 880],
    ['id' => 106, 'code' => 'LK', 'name' => "Sri Lanka", 'phonecode' => 94],
    ['id' => 107, 'code' => 'BT', 'name' => "Bhutan", 'phonecode' => 975],
    ['id' => 108, 'code' => 'MM', 'name' => "Myanmar", 'phonecode' => 95],
    ['id' => 109, 'code' => 'MV', 'name' => "Maldives", 'phonecode' => 960],
    ['id' => 110, 'code' => 'CN', 'name' => "China", 'phonecode' => 86],
];
		DB::table('countries')->insert($countries);
    }
}
