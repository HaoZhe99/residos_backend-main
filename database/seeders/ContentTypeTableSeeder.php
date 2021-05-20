<?php

namespace Database\Seeders;

use App\Models\ContentType;
use Illuminate\Database\Seeder;

class ContentTypeTableSeeder extends Seeder
{
    public function run()
    {
        $content_type = [
            [
                'id' => 1,
                'type' => 'Banner',
                'is_active' => 1,
            ],
            [
                'id' => 2,
                'type' => 'Notification',
                'is_active' => 1,
            ],
        ];

        ContentType::insert($content_type);
    }
}
