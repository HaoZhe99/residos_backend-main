<?php

namespace Database\Seeders;

use App\Models\DeveloperListing;
use Illuminate\Database\Seeder;

class DeveloperListingTableSeeder extends Seeder
{
    public function run()
    {
        $developer_listing = [
            [
                'id'                 => 1,
                'company_name'       => 'jack sdn bhn',
                'contact'            => '0123456789',
                'address'            => '15, Jln Impian 15, Taman Impian',
                'email'              => 'jackSdnBhn@gmail.com',
                'pic_id'             => 1,
            ],
        ];

        DeveloperListing::insert($developer_listing);
    }
}