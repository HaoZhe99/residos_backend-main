<?php

namespace Database\Seeders;

use App\Models\BankName;
use Illuminate\Database\Seeder;

class BankAccTableSeeder extends Seeder
{
    public function run()
    {
        $bank_names = [
            [
                'id' => 1,
                'country' => 'Malaysia',
                'bank_name' => 'MayBnak',
                'swift_code' => 'S001',
                'bank_code' => 'B001',
            ],
        ];

        BankName::insert($bank_names);
    }
}
