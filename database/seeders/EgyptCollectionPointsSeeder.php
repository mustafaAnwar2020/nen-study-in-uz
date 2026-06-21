<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class EgyptCollectionPointsSeeder extends Seeder
{
    public function run(): void
    {
        $points = [
            [
                'slug'          => 'global-ibs-nasr-city',
                'name'          => 'Global IBS',
                'country_code'  => 'eg',
                'location_type' => Location::TYPE_MAIN,
                'address'       => 'Office 48, 4th floor, Tower 2, Entrance 3, Al-Siraj Mall, 8th District, Nasr City, 11471 Cairo, Egypt',
                'land_line'     => '+201287637857/8',
                'call_center'   => '+201287637857/8',
                'email'         => 'cs@eg.nen-global.org',
                'schedule'      => 'Sunday-Thursday 10:00 AM - 6:00 PM',
                'latitude'      => '30.056090',
                'longitude'     => '31.345611',
                'map_url'       => 'https://www.google.com/maps/search/?api=1&query=Al-Siraj+Mall+Nasr+City+Cairo',
            ],
            [
                'slug'          => 'nen-6-october',
                'name'          => 'NEN | National Education Network - EG (6 October)',
                'country_code'  => 'eg',
                'location_type' => Location::TYPE_MAIN,
                'address'       => 'Building 121, Street 2, 5th District, 6 October, 12573 Giza, Egypt',
                'land_line'     => '+20236858360/61',
                'call_center'   => '+201211666800',
                'email'         => 'cs@eg.nen-global.org',
                'schedule'      => 'Sunday - Thursday, 10:00 AM - 6:00 PM',
                'latitude'      => '29.952200',
                'longitude'     => '30.921900',
                'map_url'       => 'https://www.google.com/maps/search/?api=1&query=Building+121+Street+2+5th+District+6+October+Giza',
            ],
            [
                'slug'          => 'dar-al-tanmya-mansoura',
                'name'          => 'Dar Al-Tanmya',
                'country_code'  => 'eg',
                'location_type' => Location::TYPE_MAIN,
                'address'       => 'First floor, Al-Raya Tower, University District, Mansoura, 35511 Dakahlia, Egypt',
                'land_line'     => '+2012758424040',
                'call_center'   => '+2012758424040',
                'email'         => 'cs@eg.nen-global.org',
                'schedule'      => 'Sunday-Thursday 10:00 AM - 6:00 PM',
                'latitude'      => '31.040200',
                'longitude'     => '31.380100',
                'map_url'       => 'https://www.google.com/maps/search/?api=1&query=Al-Raya+Tower+Mansoura',
            ],
        ];

        foreach ($points as $point) {
            Location::query()->updateOrCreate(
                ['slug' => $point['slug']],
                array_merge($point, ['is_active' => true])
            );
        }
    }
}
