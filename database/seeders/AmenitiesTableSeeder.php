<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitiesTableSeeder extends Seeder
{
    public function run()
    {
        $amenity = [
            [
                'id'                 => 1,
                'type'               => 'GYM Room',
            ],
            [
                'id'                 => 2,
                'type'               => 'Swimming Pool',
            ],
            [
                'id'                 => 3,
                'type'               => 'WIFI',
            ],
            [
                'id'                 => 4,
                'type'               => 'Kitchen',
            ],
            [
                'id'                 => 5,
                'type'               => 'Washer',
            ],
            [
                'id'                 => 6,
                'type'               => 'Free parking on premises',
            ],
        ];

        Amenity::insert($amenity);
    }
}