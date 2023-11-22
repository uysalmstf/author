<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function vote(Request $request) {
        
        $blog = Blog::find($request->id);
        
        $validatedData['vote'] = $request->vote;
        $vote = new Vote($validatedData);
        $blog->vote()->save($vote);

        return redirect('/blogs/read/' . $blog->id);
    }
}
