<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Str;

class StateCitySeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            'Uttar Pradesh' => ['Lucknow', 'Noida', 'Varanasi', 'Kanpur', 'Bareilly', 'Greater Noida', 'Ghaziabad', 'Meerut', 'Agra', 'Gorakhpur'],
            'Delhi NCR' => ['New Delhi', 'South Delhi', 'North Delhi'],
            'Maharashtra' => ['Mumbai', 'Pune', 'Nagpur', 'Navi Mumbai'],
            'Bihar' => ['Patna', 'Muzaffarpur', 'Gaya', 'Bhagalpur'],
            'Madhya Pradesh' => ['Bhopal', 'Indore', 'Gwalior', 'Jabalpur'],
            'Karnataka' => ['Bengaluru', 'Mysuru', 'Mangalore'],
            'Uttarakhand' => ['Dehradun', 'Haridwar', 'Roorkee', 'Pantnagar'],
        ];

        foreach ($locations as $stateName => $cities) {
            $state = State::firstOrCreate(
                ['name' => $stateName],
                ['slug' => Str::slug($stateName), 'status' => true]
            );

            foreach ($cities as $cityName) {
                City::firstOrCreate(
                    ['state_id' => $state->id, 'name' => $cityName],
                    ['slug' => Str::slug($cityName), 'is_popular' => true, 'status' => true]
                );
            }
        }
    }
}