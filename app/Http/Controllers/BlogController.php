<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

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

    public function insert(Request $request) {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        if (isset($validatedData['errors']) && $validatedData['errors'] != null) {
            return response(array('status' => false, 'message' => $validatedData['message']), 200);
        }
        $user = Auth::user();

        // Yeni bir blog oluştur
        $post = new Blog($validatedData);
        if ($user->blog()->save($post)) {
            $post->publish = 0;
            $post->view = 0;
            $post->status = 1;
            Redis::hSet('blogs', $post->id, json_encode($post));
            return response(array('status' => true), 200);
        }

    }

    public function publish($id) {
        $blog = Blog::find($id);

        $blog->publish = ($blog->publish == 0) ? 1 : 0 ;

        $blog->update();

        $blog = Redis::hGet('blogs', $id);
        $blog = json_decode($blog);

        $blog->publish = ($blog->publish == 0) ? 1 : 0 ;

        Redis::hSet('blogs', $id, json_encode($blog));

        return redirect()->route('anasayfa');

    }

    public function destroy($id) {
        $blog = Blog::find($id);

        $blog->status = 0 ;

        $blog->update();

        $blog = Redis::hDel('blogs', $id);
    
        return redirect()->route('anasayfa');

    }
    
    public function edit_api(Request $request) {

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'id' => 'required',
            'status' => 'required',
            'publish' => 'required',
        ]);
        
        if (isset($validatedData['errors']) && $validatedData['errors'] != null) {
            return response(array('status' => false, 'message' => $validatedData['message']), 200);
        }

        $post = Blog::find($request->id);

        $post->title = $request->title;
        $post->body = $request->body;
        $post->publish = $request->publish;
        $post->status = $request->status;
        $post->update();

        Redis::hSet('blogs', $post->id, json_encode($post));
        
        return response(array('status' => true), 200);
    }

    public function list()
    {
        $blogs = Redis::hGetAll('blogs');

        $blogArr = [];
        if ($blogs != null) {
            foreach ($blogs as $blog) {
               
                $blog = json_decode($blog);

                if ($blog->status == 0) {
                    continue;
                }
                if ($blog->publish == 0) {
                    continue;
                }

                $b['id'] = $blog->id;
                $b['title'] = $blog->title;
                $b['body'] = $blog->body;

                $blogArr[] = $b;
            }
        }

        $isLogin = false;
        if (Auth::check()) {
            $isLogin = true;
        }
        
        return view('blog.list', array('blogs' => $blogArr, 'isLogin' => $isLogin));
    }

    public function main_read($id) {

        $blog = Blog::find($id);
        $blog->view += 1;
        $blog->update();

        $blog = Redis::hGet('blogs', $id);
        $blog = json_decode($blog);
        $blog->view += 1;
        Redis::hSet('blogs', $id, json_encode($blog));

        $isLogin = false;

        if (Auth::check()) {
            $isLogin = true;
        }

        $onceki = 0;
        $sonraki = 0;
        $oncekiBlog = Blog::where('status', 1)->where('publish', 1)->where('id', '<', $id)->orderBy('id', 'desc')->take(1)->get();
        if(!empty($oncekiBlog) && count($oncekiBlog) > 0) {

            $onceki = $oncekiBlog[0]->id;
        }

        $sonrakiBlog = Blog::where('status', 1)->where('publish', 1)->where('id', '>', $id)->orderBy('id', 'asc')->take(1)->get();
        if(!empty($sonrakiBlog) && count($sonrakiBlog) > 0) {

            $sonraki = $sonrakiBlog[0]->id;
        }

        return view('blog.read_me', array('blog' => $blog, 'isLogin' => $isLogin, 'before' => $onceki, 'after' => $sonraki));

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
            Redis::hSet('blogs', $post->id, json_encode($post));
            return redirect('/');
        }
        return redirect('/');
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
        Redis::hSet('blogs', $post->id, json_encode($post));
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
        Redis::hSet('blogs', $id, json_encode($blog));
        return view('blog.read', array('data' => $blog, 'title' => 'Blog Editleme'));
    }
}
