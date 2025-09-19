<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
  

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//
		DB::table('states')->delete();
		$states = [
    ['id' => 1, 'name' => "Andaman and Nicobar Islands", 'country_id' => 101],
    ['id' => 2, 'name' => "Kabul Province", 'country_id' => 102],
    ['id' => 3, 'name' => "Punjab", 'country_id' => 103],
    ['id' => 4, 'name' => "Bagmati", 'country_id' => 104],
    ['id' => 5, 'name' => "Dhaka Division", 'country_id' => 105],
    ['id' => 6, 'name' => "Western Province", 'country_id' => 106],
    ['id' => 7, 'name' => "Thimphu District", 'country_id' => 107],
    ['id' => 8, 'name' => "Yangon Region", 'country_id' => 108],
    ['id' => 9, 'name' => "Male Atoll", 'country_id' => 109],
    ['id' => 10, 'name' => "Guangdong", 'country_id' => 110],
];
		DB::table('states')->insert($states);

    }
}
