<?php

namespace Database\Seeders;

use App\Models\Pic;
use Illuminate\Database\Seeder;

class PicTableSeeder extends Seeder
{
    public function run()
    {
        $pic = [
            [
                'id'                 => 1,
                'name'               => 'jack',
                'contact'            => '0123456789',
                'email'              => 'jack@gmail.com',
                'position'           => 'manager',
            ],
        ];

        Pic::insert($pic);
    }
}