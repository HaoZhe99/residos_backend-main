<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodTableSeeder extends Seeder
{
    public function run()
    {
        $payment_methods = [
            [
                'id' => 1,
                'method' => 'Online Transfer',
                'status' => 'pending',
                'description' => 'Online Transfer',
                'in_enable' => 1,
            ],
            [
                'id' => 2,
                'method' => 'PG Pay',
                'status' => 'pending',
                'description' => 'PG Pay',
                'in_enable' => 1,
            ],
        ];

        PaymentMethod::insert($payment_methods);
    }
}
