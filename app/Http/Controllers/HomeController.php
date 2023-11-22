<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

    public function writer() {
            $blogs = Blog::where('status', 1)->get();

            $blogArr = array();
            foreach ($blogs as $blog) {

                $bl['id'] = $blog->id;
                $bl['title'] = $blog->title;
                $bl['status'] = $blog->status;
                $bl['view'] = $blog->view;
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