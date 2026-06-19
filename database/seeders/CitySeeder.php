<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sauid arabia cities
        $cities = [
            [
                'name' => 'الرياض',
                'is_active' => true,
            ],
            [
                'name' => 'مكة المكرمة',
                'is_active' => true,
            ],
            [
                'name' => 'المدينة المنورة',
                'is_active' => true,
            ],
            [
                'name' => 'الدمام',
                'is_active' => false,
            ],
            [
                'name' => 'تبوك',
                'is_active' => false,
            ],
            [
                'name'=> 'القطيف',
                'is_active' => true,
            ],
            [
                'name' => 'خميس مشيط',
                'is_active' => false,
            ]
        ];


        foreach ($cities as $city) {
            City::create($city);
        }

    }
}
