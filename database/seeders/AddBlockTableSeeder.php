<?php

namespace Database\Seeders;

use App\Models\AddBlock;
use Illuminate\Database\Seeder;

class AddBlockTableSeeder extends Seeder
{
    public function run()
    {
        $add_blocks = [
            [
                'id'                 => 1,
                'block'              => 'A',
                'project_code_id'    => 1,
            ],
        ];

        AddBlock::insert($add_blocks);
    }
}