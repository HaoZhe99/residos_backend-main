<?php

namespace Database\Seeders;

use App\Models\SMS;
use Illuminate\Database\Seeder;

class SMSTableSeeder extends Seeder
{
    public function run()
    {
        $sms = [
            [
                'id' => 1,
                'username' => 'ss4094',
                'secret_key' => 'c2bupq5ch',
            ],
        ];

        SMS::insert($sms);
    }
}
