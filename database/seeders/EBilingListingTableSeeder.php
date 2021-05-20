<?php

namespace Database\Seeders;

use App\Models\EBillListing;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EBilingListingTableSeeder extends Seeder
{
    public function run()
    {
        $e_bill_listings = [
            [
                'id' => 1,
                'type' => 'Maintenance',
                'amount' => 100,
                'expired_date' => Carbon::now(),
                'remark' => '',
                'status' => 'outstanding',
                'project_id' => 1,
                'unit_id' => 1,
                'bank_acc_id' => 1,
                'username_id' => 2,
                'payment_method_id' => 1,
            ],
        ];

        EBillListing::insert($e_bill_listings);
    }
}
