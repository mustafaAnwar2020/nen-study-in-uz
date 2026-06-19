<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $countryData = [
            'us' => ['name' => 'United States Location', 'address' => 'Ad St , 12 US', 'latitude' => '40.7128', 'longitude' => '-74.0060'],
            'gb' => ['name' => 'United Kingdom Location', 'address' => 'Ad St , 12 UK', 'latitude' => '51.5074', 'longitude' => '-0.1278'],
            'de' => ['name' => 'Germany Location', 'address' => 'Ad St , 12 Berlin', 'latitude' => '52.5200', 'longitude' => '13.4050'],
            'tr' => ['name' => 'Turkey Location', 'address' => 'Ad St , 12 Istanbul', 'latitude' => '41.0082', 'longitude' => '28.9784'],
            'eg' => ['name' => 'Egypt Location', 'address' => 'Ad St , 12 Cairo', 'latitude' => '30.0444', 'longitude' => '31.2357'],
            'jo' => ['name' => 'Jordan Location', 'address' => 'Ad St , 12 Amman', 'latitude' => '31.9454', 'longitude' => '35.9284'],
            'sa' => ['name' => 'Saudi Arabia Location', 'address' => 'Ad St , 12 Riyadh', 'latitude' => '24.7136', 'longitude' => '46.6753'],
            'ae' => ['name' => 'United Arab Emirates Location', 'address' => 'Ad St , 12 Dubai', 'latitude' => '25.276987', 'longitude' => '55.296249'],
            'om' => ['name' => 'Oman Location', 'address' => 'Ad St , 12 Muscat', 'latitude' => '23.5859', 'longitude' => '58.4059'],
            'az' => ['name' => 'Azerbaijan Location', 'address' => 'Ad St , 12 Baku', 'latitude' => '40.4093', 'longitude' => '49.8671'],
            'uz' => ['name' => 'Uzbekistan Location', 'address' => 'Ad St , 12 Tashkent', 'latitude' => '41.2995', 'longitude' => '69.2401'],
            'kg' => ['name' => 'Kyrgyzstan Location', 'address' => 'Ad St , 12 Bishkek', 'latitude' => '42.8746', 'longitude' => '74.5698'],
            'in' => ['name' => 'India Location', 'address' => 'Ad St , 12 Delhi', 'latitude' => '28.6139', 'longitude' => '77.2090'],
            'cn' => ['name' => 'China Location', 'address' => 'Ad St , 12 Beijing', 'latitude' => '39.9042', 'longitude' => '116.4074'],
        ];

        $locations = [];
        foreach ($countryData as $code => $data) {
            $locations[] = [
                'slug' => Location::generateSlug(),
                'name' => $data['name'],
                'country_code' => $code,
                'address' => $data['address'],
                'land_line' => '08882121212',
                'call_center' => '123021213213',
                'email' => strtolower(str_replace(' ', '_', $data['name'])) . '@test.com',
                'phone' => '32132133',
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'schedule' => 'Mon-Fri, 9 AM - 5 PM',
            ];
        }

        foreach ($locations as $location) {
            Location::query()->create($location);
        }
    }
}
