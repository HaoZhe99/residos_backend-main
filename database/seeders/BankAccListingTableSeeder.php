<?php

namespace Database\Seeders;

use App\Models\BankAccListing;
use Illuminate\Database\Seeder;

class BankAccListingTableSeeder extends Seeder
{
    public function run()
    {
        $bank_acc_listings = [
            [
                'id' => 1,
                'bank_account' => 'B123456789',
                'status' => 'pending',
                'is_active' => 1,
                'balance' => 1000,
                'project_code_id' => 1,
            ],
        ];

        BankAccListing::insert($bank_acc_listings);
    }
}
