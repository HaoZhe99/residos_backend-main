<?php

namespace Database\Seeders;

use App\Models\Rent;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RentTableSeeder extends Seeder
{
    public function run()
    {
        $rents = [
            [
                'id' => 1,
                'tenant_id' => 3,
                'rent_fee' => 100,
                'day_of_month' => 8,
                'leases' => 3,
                'start_rent_day' => Carbon::now(),
                'end_rent_day' =>  Carbon::now()->addMonth(3),
                'bank_acc' => 123,
                'status' => "rented",
                'type' => "unit",
                'slot_limit' => 1,
                'room_size' => 1,
                'unit_owner_id' => 2,
            ],
        ];

        Rent::insert($rents);
    }
}
