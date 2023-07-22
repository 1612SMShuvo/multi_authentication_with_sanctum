<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Affiliator;

class Initials extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin['name'] = "Shuvo";
        $admin['email'] = "shuvo@gmail.com";
        $admin['phone'] = "01234567890";
        $admin['skype'] = "www.skype.com/shuvo0123456789";
        $admin['website'] = "www.shuvo.com";
        $admin['country'] = "Bangladesh";
        $admin['password'] = Hash::make("123456");

        User::create($admin);

        $affiliator['name'] = "John";
        $affiliator['email'] = "john@gmail.com";
        $affiliator['phone'] = "01976543210";
        $affiliator['skype'] = "www.skype.com/john01976543210";
        $affiliator['website'] = "www.john.com";
        $affiliator['promotional_method'] = "Coupon";
        $affiliator['address'] = "Moghbazar, Dhaka";
        $affiliator['division'] = "Dhaka";
        $affiliator['country'] = "Bangladesh";
        $affiliator['password'] = Hash::make("123456");

        Affiliator::create($affiliator);

    }
}
