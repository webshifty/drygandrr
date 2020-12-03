<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::factory()->create([
            'name' => 'Ukraine',
            'iso2' => 'ISO 3166-2:UA'
        ]);
        Country::factory()->create([
            'name' => 'Poland',
            'iso2' => 'ISO 3166-2:PL'
        ]);
    }
}
