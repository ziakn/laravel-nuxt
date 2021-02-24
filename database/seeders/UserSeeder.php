<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                [
                    'name' => 'Admin',
                    'email' => 'admin@gmail.com',
                    'password' => bcrypt('asdasdasd'),
                    'mobile' => '12345678',
                    'address' => 'Doha Qatar',
                    'status' => 1,
                    'image' => '/profile.png',
                ],
            ]
        );
    }
}
