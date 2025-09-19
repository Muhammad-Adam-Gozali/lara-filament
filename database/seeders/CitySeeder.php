<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * the cities is large, we need to break it in parts
     * @return void
     */
    public function run()
    {
        //
        DB::table('cities')->delete();
        $cities = [
    ['name' => "Bombuflat", 'state_id' => 1],
    ['name' => "Kabul", 'state_id' => 2],
    ['name' => "Lahore", 'state_id' => 3],
    ['name' => "Kathmandu", 'state_id' => 4],
    ['name' => "Dhaka", 'state_id' => 5],
    ['name' => "Colombo", 'state_id' => 6],
    ['name' => "Thimphu", 'state_id' => 7],
    ['name' => "Yangon", 'state_id' => 8],
    ['name' => "Male", 'state_id' => 9],
    ['name' => "Guangzhou", 'state_id' => 10],
];
        DB::table('cities')->insert($cities);
    }
}