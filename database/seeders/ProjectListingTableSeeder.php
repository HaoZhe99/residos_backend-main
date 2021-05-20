<?php

namespace Database\Seeders;

use App\Models\ProjectListing;
use Illuminate\Database\Seeder;

class ProjectListingTableSeeder extends Seeder
{
    public function run()
    {
        $project_listing = [
            [
                'id'                 => 1,
                'name'               => 'Project 1',
                'address'            => '15, Jln Impian 15, Taman Impian',
                'tenure'             => 'freehold',
                'completion_date'    => '2021-03-12 14:18:59',
                'status'             => 'approve',
                'project_code'       => 'Project ' . mt_rand(100, 999),
                'type_id'            => 1,
                'developer_id'       => 1,
                'area_id'            => 1,
                'pic_id'             => 1,
                'create_by'          => 1,
            ],
        ];

        ProjectListing::insert($project_listing);
    }
}
