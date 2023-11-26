<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Mobilium Admin',
            'email' => 'admin@mobillium.com',
            'password' => bcrypt('mobillium'),
        ]);

        DB::table('users')->insert([
            'name' => 'Mobilium Writer',
            'email' => 'writer1@mobillium.com',
            'password' => bcrypt('mobillium'),
        ]);
    }
}
