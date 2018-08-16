<?php

//use App\User;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    public function run()
    {
        User::truncate();
        User::create([
            "token" => 'admin-token',
            "uuid" => 'admin',
            "username" => 'admin',
            "password" => bcrypt('admin'),
            "realname" => '系统管理员',
            "title" => '系统管理员',
            "role_uuid" => 'role-admin',
        ]);

        User::create([
            "token" => 'test-token',
            "uuid" => 'user-0000',
            "username" => '0000',
            "password" => bcrypt('test'),
            "realname" => '用户',
            "title" => '测试用户',
            "role_uuid" => 'role-manager',
        ]);


    }
}
