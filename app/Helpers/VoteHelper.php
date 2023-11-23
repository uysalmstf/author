<?php

use App\Models\Vote;

function voteCalculate($votes) {

    $total = 0;
    $result = 0;
    $totalVotes = count($votes);

    if (count($votes) > 0) {
        foreach ($votes as $key => $vote) {
            $total += $vote->vote;
        }

        if (count($votes) > 2) {
            $limit = count($votes) % 3;
            if ($limit == 0) {
                $limit = 1;
            }

            $lastVote = Vote::where('blog_id', $vote->blog_id)
                        ->orderBy('created_at', 'desc')->take($limit)->get();
            foreach ($lastVote as $key => $lv) {
                $total += $lv->vote;
                $totalVotes++;

            }      
        }
        $result = $total / $totalVotes;
    }
    
    return $result;
}