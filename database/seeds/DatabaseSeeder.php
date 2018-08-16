<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Eloquent::unguard();


        $this->call(UserTableSeeder::class);

        $this->call(SweeperTableSeeder::class);


        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
