<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    public function index() {

        
        return view('home.index', array(
            'title' => 'nothing'));
    }
    
    public function admin() {
        $blogs = Redis::hGetAll('blogs');
        
        $blogArr = array();
        foreach ($blogs as $key => $blog) {
            
            $blog = json_decode($blog);
            $blogVotes = Vote::where('blog_id', $blog->id)->get();
            $blogUser = User::where('id', $blog->user_id)->first();

            $bl['id'] = $blog->id;
            $bl['title'] = $blog->title;
            $bl['status'] = $blog->status;
            $bl['view'] = $blog->view;
            $bl['vote'] = voteCalculate($blogVotes);
            $bl['publish'] = $blog->publish;
            $bl['user'] = $blogUser->name;
            $bl['actions'] = '<a href="'.route('main.read', ['id' => $blog->id]).'" class="btn btn-info">Oku</a>';

            if ($blogUser->id == Auth::user()->id) {
                
                if (Auth::user()->type != 0) {

                    if (Auth::user()->type == 3) {
                        
                        if ($blog->user_id == Auth::id()) {
                            $bl['actions'] .= '<a href="'.route('edit', ['id' => $blog->id]).'" class="btn btn-warning">Düzenle</a>';
                        }
                    }else {
                        
                        $bl['actions'] .= '<a href="'.route('edit', ['id' => $blog->id]).'" class="btn btn-warning">Düzenle</a>';
                        $bl['actions'] .= '<a href="'.route('publish', ['id' => $blog->id]).'" class="btn btn-primary">Yayın Durumu Değiştir</a>';
                        $bl['actions'] .= '<a href="'.route('delete', ['id' => $blog->id]).'" class="btn btn-danger">Sil</a>';
                    }
                }
            }

            $blogArr[] = $bl;
        }
        

        $isOKForCreate = false;
        if (Auth::user()->type != 0) {
            $isOKForCreate = true;
        }
        return view('home.index', array(
            'title' => 'admin',
            'blogs' => $blogArr,
            'create' => $isOKForCreate));
    }

    public function moderator() {

        $blogs = Redis::hGetAll('blogs');
        
            $blogs = Blog::where('status', 1)->get();

            $blogArr = array();
            foreach ($blogs as $blog) {

                $bl['id'] = $blog->id;
                $bl['title'] = $blog->title;
                $bl['status'] = $blog->status;
                $bl['view'] = $blog->view;
                $bl['vote'] = voteCalculate($blog->votes);
                $bl['publish'] = $blog->publish;
                $bl['user'] = $blog->user->name;
                $bl['actions'] = '<a href="'.route('main.read', ['id' => $blog->id]).'" class="btn btn-info">Oku</a>';

                if ($blog->user->id == Auth::user()->id) {
                    if (Auth::user()->type != 0) {

                        $bl['actions'] .= '<a href="'.route('edit', ['id' => $blog->id]).'" class="btn btn-warning">Düzenle</a>';

                    }
                }

                $blogArr[] = $bl;

            }
        

        $isOKForCreate = false;
        if (Auth::user()->type != 0) {
            $isOKForCreate = true;
        }
        return view('home.index', array(
            'title' => 'moderator',
            'blogs' => $blogArr,
            'create' => $isOKForCreate));
    }

    public function writer() {

        $blogs = Redis::hGetAll('blogs');
        
            $blogs = Blog::where('status', 1)->get();

            $blogArr = array();
            foreach ($blogs as $blog) {

                $bl['id'] = $blog->id;
                $bl['title'] = $blog->title;
                $bl['status'] = $blog->status;
                $bl['view'] = $blog->view;
                $bl['vote'] = voteCalculate($blog->votes);
                $bl['publish'] = $blog->publish;
                $bl['user'] = $blog->user->name;
                $bl['actions'] = '<a href="'.route('main.read', ['id' => $blog->id]).'" class="btn btn-info">Oku</a>';

                if ($blog->user->id == Auth::user()->id) {
                    if (Auth::user()->type != 0) {

                        $bl['actions'] .= '<a href="'.route('edit', ['id' => $blog->id]).'" class="btn btn-warning">Düzenle</a>';

                    }
                }

                $blogArr[] = $bl;

            }
        

        $isOKForCreate = false;
        if (Auth::user()->type != 0) {
            $isOKForCreate = true;
        }
        return view('home.index', array(
            'title' => 'writer',
            'blogs' => $blogArr,
            'create' => $isOKForCreate));
    }

    public function reader() {

        $blogs = Redis::hGetAll('blogs');
        
            $blogs = Blog::where('status', 1)->get();

            $blogArr = array();
            foreach ($blogs as $blog) {

                $bl['id'] = $blog->id;
                $bl['title'] = $blog->title;
                $bl['status'] = $blog->status;
                $bl['view'] = $blog->view;
                $bl['vote'] = voteCalculate($blog->votes);
                $bl['publish'] = $blog->publish;
                $bl['user'] = $blog->user->name;
                $bl['actions'] = '<a href="'.route('main.read', ['id' => $blog->id]).'" class="btn btn-info">Oku</a>';

                if ($blog->user->id == Auth::user()->id) {
                    if (Auth::user()->type != 0) {

                        $bl['actions'] .= '<a href="'.route('edit', ['id' => $blog->id]).'" class="btn btn-warning">Düzenle</a>';

                    }
                }

                $blogArr[] = $bl;

            }
        

        $isOKForCreate = false;
        if (Auth::user()->type != 0) {
            $isOKForCreate = true;
        }
        return view('home.index', array(
            'title' => 'reader',
            'blogs' => $blogArr,
            'create' => $isOKForCreate));
    }
}
