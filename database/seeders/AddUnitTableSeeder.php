<?php

namespace Database\Seeders;

use App\Models\AddUnit;
use Illuminate\Database\Seeder;

class AddUnitTableSeeder extends Seeder
{
    public function run()
    {
        $add_units = [
            [
                'id'                 => 1,
                'unit'               => '1',
                'floor'              => 1,
                'square'             => 1,
                'meter'              => '100',
                'block_id'           => 1,
                'project_code_id'    => 1,
            ],
            [
                'id'                 => 2,
                'unit'               => '2',
                'floor'              => 2,
                'square'             => 2,
                'meter'              => '200',
                'block_id'           => 1,
                'project_code_id'    => 1,
            ],
        ];

        AddUnit::insert($add_units);
    }
}