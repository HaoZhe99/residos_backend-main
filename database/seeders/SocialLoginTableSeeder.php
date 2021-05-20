<?php

namespace Database\Seeders;

use App\Models\SocialLogin;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SocialLoginTableSeeder extends Seeder
{
    public function run()
    {
        $socialLogin = [
            [
                'id' => 1,
                'name' => 'Residos',
                'user_id' => 1,
                'secret' => Str::random(40),
                'redirect' => 'http://fin.techworlds.com.my/oauth/callback',
                'personal_access_client' => 0,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Residos Api',
                'user_id' => 1,
                'secret' => Str::random(40),
                'redirect' => 'http://fin.techworlds.com.my/api/v1/oauth/callback',
                'personal_access_client' => 0,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        SocialLogin::insert($socialLogin);
    }
}
