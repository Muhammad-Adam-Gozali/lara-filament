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
    ['name' => "Andaman and Nicobar Islands", 'country_id' => 1],
     ['name' => "Kabul Province", 'country_id' => 2],
    ['name' => "Punjab", 'country_id' => 3],
     ['name' => "Bagmati", 'country_id' => 4],
    ['name' => "Dhaka Division", 'country_id' => 5],
    ['name' => "Western Province", 'country_id' => 6],
    ['name' => "Thimphu District", 'country_id' => 7],
    ['name' => "Yangon Region", 'country_id' => 8],
    ['name' => "Male Atoll", 'country_id' => 9],
    [ 'name' => "Guangdong", 'country_id' => 10],
];
		DB::table('states')->insert($states);

    }
}
