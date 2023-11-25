<?php

namespace Tests\Feature;

use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VoteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
       $votes = Vote::factory(3)->create();

       require_once base_path('app/Helpers/VoteHelper.php');

        foreach ($votes as $key => $value) {
            echo $value->vote;
        }

       $result = voteCalculate($votes);

       $this->assertNotEquals(0, $result);
    }
}
