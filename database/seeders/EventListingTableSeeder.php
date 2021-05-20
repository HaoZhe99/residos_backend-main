<?php

namespace Database\Seeders;

use App\Models\EventListing;
use Illuminate\Database\Seeder;

class EventListingTableSeeder extends Seeder
{
    public function run()
    {
        $event_listing = [
            [

                'id'                 => 1,
                'event_code'           => 'S001',
                'title'         => 'Speech 1',
                'description'   => 'Speech',
                'language'      => 'English',
                'status'    => 'upcoming',
                'catogery_id' => 1,
                'created_by_id' => 1,
                'user_group_id' => 1,
                'created_at' => '2021-04-23 18:16:40',
            ],
            [

                'id'                 => 2,
                'event_code'           => 'S001',
                'title'         => 'Speech 1',
                'description'   => 'Speech',
                'language'      => 'English',
                'status'    => 'upcoming',
                'catogery_id' => 1,
                'created_by_id' => 1,
                'user_group_id' => 1,
                'created_at' => '2021-04-23 18:16:40',
            ],
            [

                'id'                 => 3,
                'event_code'           => 'S001',
                'title'         => 'Speech 1',
                'description'   => 'Speech',
                'language'      => 'English',
                'status'    => 'upcoming',
                'catogery_id' => 1,
                'created_by_id' => 1,
                'user_group_id' => 1,
                'created_at' => '2021-04-23 18:16:40',
            ],
            [

                'id'                 => 4,
                'event_code'           => 'S001',
                'title'         => 'Speech 1',
                'description'   => 'Speech',
                'language'      => 'English',
                'status'    => 'upcoming',
                'catogery_id' => 1,
                'created_by_id' => 1,
                'user_group_id' => 1,
                'created_at' => '2021-04-23 18:16:40',
            ],
            [

                'id'                 => 5,
                'event_code'           => 'S001',
                'title'         => 'Speech 1',
                'description'   => 'Speech',
                'language'      => 'English',
                'status'    => 'upcoming',
                'catogery_id' => 1,
                'created_by_id' => 1,
                'user_group_id' => 1,
                'created_at' => '2021-04-23 18:16:40',
            ],
            [

                'id'                 => 6,
                'event_code'           => 'S001',
                'title'         => 'Speech 1',
                'description'   => 'Speech',
                'language'      => 'English',
                'status'    => 'upcoming',
                'catogery_id' => 1,
                'created_by_id' => 1,
                'user_group_id' => 1,
                'created_at' => '2021-04-23 18:16:40',
            ],
            [

                'id'                 => 7,
                'event_code'           => 'S001',
                'title'         => 'Speech 1',
                'description'   => 'Speech',
                'language'      => 'English',
                'status'    => 'upcoming',
                'catogery_id' => 1,
                'created_by_id' => 1,
                'user_group_id' => 1,
                'created_at' => '2021-04-23 18:16:40',
            ],
            [

                'id'                 => 8,
                'event_code'           => 'S001',
                'title'         => 'Speech 1',
                'description'   => 'Speech',
                'language'      => 'English',
                'status'    => 'upcoming',
                'catogery_id' => 1,
                'created_by_id' => 1,
                'user_group_id' => 1,
                'created_at' => '2021-04-23 18:16:40',
            ],
            [

                'id'                 => 9,
                'event_code'           => 'S001',
                'title'         => 'Speech 1',
                'description'   => 'Speech',
                'language'      => 'English',
                'status'    => 'upcoming',
                'catogery_id' => 1,
                'created_by_id' => 1,
                'user_group_id' => 1,
                'created_at' => '2021-04-23 18:16:40',
            ],
            [

                'id'                 => 10,
                'event_code'           => 'S001',
                'title'         => 'Speech 1',
                'description'   => 'Speech',
                'language'      => 'English',
                'status'    => 'upcoming',
                'catogery_id' => 1,
                'created_by_id' => 1,
                'user_group_id' => 1,
                'created_at' => '2021-04-23 18:16:40',
            ],
        ];

        EventListing::insert($event_listing);
    }
}
