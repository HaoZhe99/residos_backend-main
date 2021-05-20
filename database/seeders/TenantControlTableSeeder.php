<?php

namespace Database\Seeders;

use App\Models\TenantControl;
use Illuminate\Database\Seeder;

class TenantControlTableSeeder extends Seeder
{
    public function run()
    {
        $tenant_control = [
            [
                'id' => 1,
                'tenant_id' => 3,
                'rent_id' => 1,
                'status' => "unit",
            ],
        ];

        TenantControl::insert($tenant_control);
    }
}
