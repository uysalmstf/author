<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(5)
            ->has(
                Blog::factory(3)
                    ->has(Vote::factory(5))
            )
            ->create();
            
    }
}
