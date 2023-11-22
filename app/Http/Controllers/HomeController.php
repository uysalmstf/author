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

        $blogs = Blog::where('status', 1)->get();
            $blogArr = array();
            foreach ($blogs as $blog) {

                $bl['id'] = $blog->id;
                $bl['title'] = $blog->title;
                $bl['status'] = $blog->status;
                $bl['publish'] = $blog->publish;
                $bl['user'] = $blog->user->name;
                $bl['actions'] = '<a href="'.route('read').'/'.$blog->id.'" class="btn btn-info">Oku</a>';

                if ($blog->user->id == Auth::user()->id) {
                    if (Auth::user()->type != 0) {
                        if ($blog->publish == 1) {
                            $bl['actions'] .= '<a onclick="publish('.$blog->id.', '.$blog->publish.')" class="btn btn-warning yayin'.$blog->id.'">Yayından Kaldır</a>';
                        } else {
                            $bl['actions'] .= '<a onclick="publish('.$blog->id.', '.$blog->publish.')" class="btn btn-warning yayin'.$blog->id.'">Yayına Al</a>';
                        }

                        $bl['actions'] .= '<a href="'.route('edit').'/'.$blog->id.'" class="btn btn-info">Düzenle</a>';

                    }
                }

                $blogArr[] = $bl;

            }

        

        $isOKForCreate = false;
        if (Auth::user()->type != 0) {
            $isOKForCreate = true;
        }
        return view('home.index', array(
            'title' => 'nothing',
            'blogs' => $blogArr,
            'create' => $isOKForCreate));
    }
    
    public function admin() {
            $blogs = Blog::where('status', 1)->get();

            $blogArr = array();
            foreach ($blogs as $blog) {

                $bl['id'] = $blog->id;
                $bl['title'] = $blog->title;
                $bl['status'] = $blog->status;
                $bl['publish'] = $blog->publish;
                $bl['user'] = $blog->user->name;
                $bl['actions'] = '<a href="'.route('read').'/'.$blog->id.'" class="btn btn-info">Oku</a>';

                if ($blog->user->id == Auth::user()->id) {
                    if (Auth::user()->type != 0) {
                        if ($blog->publish == 1) {
                            $bl['actions'] .= '<a onclick="publish('.$blog->id.', '.$blog->publish.')" class="btn btn-warning yayin'.$blog->id.'">Yayından Kaldır</a>';
                        } else {
                            $bl['actions'] .= '<a onclick="publish('.$blog->id.', '.$blog->publish.')" class="btn btn-warning yayin'.$blog->id.'">Yayına Al</a>';
                        }

                        $bl['actions'] .= '<a href="'.route('edit').'/'.$blog->id.'" class="btn btn-info">Düzenle</a>';

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

            $blogs = Blog::where('status', 1)->get();

            $blogArr = array();
            foreach ($blogs as $blog) {

                $bl['id'] = $blog->id;
                $bl['title'] = $blog->title;
                $bl['status'] = $blog->status;
                $bl['publish'] = $blog->publish;
                $bl['user'] = $blog->user->name;
                $bl['actions'] = '<a href="'.route('read').'/'.$blog->id.'" class="btn btn-info">Oku</a>';

                if ($blog->user->id == Auth::user()->id) {
                    if (Auth::user()->type != 0) {
                        if ($blog->publish == 1) {
                            $bl['actions'] .= '<a onclick="publish('.$blog->id.', '.$blog->publish.')" class="btn btn-warning yayin'.$blog->id.'">Yayından Kaldır</a>';
                        } else {
                            $bl['actions'] .= '<a onclick="publish('.$blog->id.', '.$blog->publish.')" class="btn btn-warning yayin'.$blog->id.'">Yayına Al</a>';
                        }

                        $bl['actions'] .= '<a href="'.route('edit').'/'.$blog->id.'" class="btn btn-info">Düzenle</a>';

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

    public function voteCalculate($votes) {

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

    public function writer() {

        $blogs = Redis::hGetAll('blogs');
        if($blogs == null) {
            $blogs = Blog::where('status', 1)->get()->toArray();

            $blogArr = array();
            foreach ($blogs as $blog) {

                $bl['id'] = $blog->id;
                $bl['title'] = $blog->title;
                $bl['status'] = $blog->status;
                $bl['view'] = $blog->view;
                $bl['vote'] = $this->voteCalculate($blog->votes);
                $bl['publish'] = $blog->publish;
                $bl['user'] = $blog->user->name;
                $bl['actions'] = '<a href="blogs/read/'.$blog->id.'" class="btn btn-info">Oku</a>';

                if ($blog->user->id == Auth::user()->id) {
                    if (Auth::user()->type != 0) {

                        $bl['actions'] .= '<a href="blogs/edit/'.$blog->id.'" class="btn btn-warning">Düzenle</a>';

                    }
                }

                $blogArr[] = $bl;

            }
        } else {

            $blogArr = array();
            foreach ($blogs as $key => $blog) {
               
                $blog = json_decode($blog);
                $blogVotes = Vote::where('blog_id', $blog->id)->get();
                $blogUser = User::where('id', $blog->user_id)->first();

                $bl['id'] = $blog->id;
                $bl['title'] = $blog->title;
                $bl['status'] = $blog->status;
                $bl['view'] = $blog->view;
                $bl['vote'] = $this->voteCalculate($blogVotes);
                $bl['publish'] = $blog->publish;
                $bl['user'] = $blogUser->name;
                $bl['actions'] = '<a href="blogs/read/'.$blog->id.'" class="btn btn-info">Oku</a>';

                if ($blogUser->id == Auth::user()->id) {
                    if (Auth::user()->type != 0) {

                        $bl['actions'] .= '<a href="blogs/edit/'.$blog->id.'" class="btn btn-warning">Düzenle</a>';

                    }
                }

                $blogArr[] = $bl;
            }
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

            $blogs = Blog::where('status', 1)->get();

            $blogArr = array();
            foreach ($blogs as $blog) {

                $bl['id'] = $blog->id;
                $bl['title'] = $blog->title;
                $bl['status'] = $blog->status;
                $bl['publish'] = $blog->publish;
                $bl['user'] = $blog->user->name;
                $bl['actions'] = '<a href="'.route('read').'/'.$blog->id.'" class="btn btn-info">Oku</a>';

                if ($blog->user->id == Auth::user()->id) {
                    if (Auth::user()->type != 0) {


                        $bl['actions'] .= '<a href="'.route('edit').'/'.$blog->id.'" class="btn btn-info">Düzenle</a>';

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
