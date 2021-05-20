<?php

namespace Database\Seeders;

use App\Models\UnitManagement;
use Illuminate\Database\Seeder;

class UnitManagementTableSeeder extends Seeder
{
    public function run()
    {
        $unit_mangements = [
            [
                'id' => 1,
                'floor_size' => '1',
                'bed_room' => '1',
                'toilet' => '1',
                'floor_level' => '1',
                'carpark_slot' => '1',
                'bumi_lot' => 1,
                'block' => 'A',
                'status' => 'owned',
                'balcony' => 1,
                'unit_code' => 'A' . mt_rand(100, 999),
                'unit_owner' => 'A0101-User',
                'project_code_id' => 1,
                'unit_id' => 1,
                'owner_id' => 2,
            ],
            [
                'id' => 2,
                'floor_size' => '2',
                'bed_room' => '2',
                'toilet' => '2',
                'floor_level' => '2',
                'carpark_slot' => '2',
                'bumi_lot' => 1,
                'block' => 'A',
                'status' => 'rent - entire',
                'balcony' => 1,
                'unit_code' => 'A' . mt_rand(100, 999),
                'unit_owner' => 'A0202-User',
                'project_code_id' => 1,
                'unit_id' => 2,
                'owner_id' => 2,
            ],
        ];

        UnitManagement::insert($unit_mangements);
    }
}
