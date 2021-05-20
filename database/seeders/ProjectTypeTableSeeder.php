<?php

namespace Database\Seeders;

use App\Models\ProjectType;
use Illuminate\Database\Seeder;

class ProjectTypeTableSeeder extends Seeder
{
    public function run()
    {
        $project_type = [
            [
                'id'                 => 1,
                'type'               => 'Apartment',
                'category_id' => 1,
            ],
        ];

        ProjectType::insert($project_type);
    }
}