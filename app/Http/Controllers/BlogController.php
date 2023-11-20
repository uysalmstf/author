<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('blog.add', array('title' => 'Blog Ekleme'));
    }

    public function list()
    {
        $response = ['message' =>  'list function'];
        return response($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        // Kullanıcının ilişkilendirilmiş modelini al
        $user = auth()->user();

        // Blog yazısı oluştur ve ilişkilendir
        $post = new Blog($validatedData);
        if ($user->blog()->save($post)) {
            $post->publish = 0;
            $post->view = 0;
            $post->status = 1;

            return redirect('/');
        }
        return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
            $blog = Blog::where('id', $id)->first();

        return view('blog.edit', array('data' => $blog, 'title' => 'Blog Editleme'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $post = Blog::find($id);
        $post->publish = $request->get('publish');
        $post->status = $request->get('status');
        $post->update($validatedData);
        
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function read($id)
    {
        $blog = Blog::where('id', $id)->first();
        $blog->view += 1;
        $blog->save();
        return view('blog.edit', array('data' => $blog, 'title' => 'Blog Editleme'));
    }
}
