<?php

use App\Models\Sweeper;
use Illuminate\Database\Seeder;

class SweeperTableSeeder extends Seeder
{

    public function run()
    {
        Sweeper::truncate();
        Sweeper::create(array(
            "uuid" => '1234',
            "code" => '1234',
            "title" => '京A6666',
        ));
        Sweeper::create(array(
            "uuid" => '5678',
            "code" => '5678',
            "title" => '京B8888',
        ));
    }
} 