<?php

namespace Database\Seeders;

use App\Models\AddUnit;
use App\Models\EventCategory;
use Illuminate\Database\Seeder;

class EventCategoryTableSeeder extends Seeder
{
    public function run()
    {
        $event_category = [
            [
                'id'                 => 1,
                'cateogey'               => 'Speech',
            ],
        ];

        EventCategory::insert($event_category);
    }
}
