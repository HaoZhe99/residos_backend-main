<?php

namespace Database\Seeders;

use App\Models\ProjectCategory;
use Illuminate\Database\Seeder;

class ProjectCategoryTableSeeder extends Seeder
{
    public function run()
    {
        $project_category = [
            [
                'id'                 => 1,
                'project_category'   => 'Building',
            ],
        ];

        ProjectCategory::insert($project_category);
    }
}
