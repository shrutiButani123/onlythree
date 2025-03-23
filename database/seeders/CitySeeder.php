<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $maharashtra = State::where('name', 'Maharashtra')->first();
        $gujarat = State::where('name', 'Gujarat')->first();

        City::create(['name' => 'Mumbai', 'state_id' => $maharashtra->id]);
        City::create(['name' => 'Pune', 'state_id' => $maharashtra->id]);
        City::create(['name' => 'Surat', 'state_id' => $gujarat->id]);
        City::create(['name' => 'Ahmedabad', 'state_id' => $gujarat->id]);
    }
}
