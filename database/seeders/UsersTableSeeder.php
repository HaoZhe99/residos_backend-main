<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\ProjectCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'                 => 1,
                'name'               => 'Admin',
                'email'              => 'admin@admin.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'verified'           => 1,
                'verified_at'        => '2021-03-11 02:36:21',
                'verification_token' => '',
                'contact_number'     => '123456789',
                'ic_number'          => '',
            ],
            [
                'id'                 => 2,
                'name'               => 'User',
                'email'              => 'user@user.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'verified'           => 1,
                'verified_at'        => '2021-03-11 02:36:21',
                'verification_token' => '',
                'contact_number'     => '',
                'ic_number'          => '',
            ],
            [
                'id'                 => 3,
                'name'               => 'Tenant',
                'email'              => 'tenant@tenant.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'verified'           => 1,
                'verified_at'        => '2021-03-11 02:36:21',
                'verification_token' => '',
                'contact_number'     => '12305574',
                'ic_number'          => '',
            ],
        ];

        User::insert($users);
    }
}
