@extends('layouts.site')
@section('content')
    <div class="card">
            <div class="card-header">
                @if($isLogin)
                <a href="{{route('auth.logout')}}" class="btn btn-danger">Logout</a>
                @else
                <a href="{{route('auth.login')}}" class="btn btn-success">Login</a>
                <a href="{{route('auth.register')}}" class="btn btn-info">Kayıt Ol</a>
                @endif
            </div>
            <div class="card-body">
                <div class="card">

                    <div class="card-header"><?=$blog->title?></div>
                    <div class="card-body">
                            <div class="row">
                                <?=$blog->body?>
                            </div>
                            <div class="row">
                                <div class="part">
                                <p>Oylama </p>
                                    <div class="stars rate" data-percent="0">
                                        <a
                                        @if ($isLogin)
                                        href="{{route('vote', ['id' => $blog->id, 'vote' => 1])}}"
                                        @else
                                        href="#"    
                                        @endif
                                         title="awful">★</a>
                                        <a
                                        @if ($isLogin)
                                        href="{{route('vote', ['id' => $blog->id, 'vote' => 2])}}"
                                        @else
                                        href="#"    
                                        @endif
                                         title="ok">★</a>
                                        <a
                                        @if ($isLogin)
                                        href="{{route('vote', ['id' => $blog->id, 'vote' => 3])}}"
                                        @else
                                        href="#"    
                                        @endif
                                         title="good">★</a>
                                        <a
                                        @if ($isLogin)
                                        href="{{route('vote', ['id' => $blog->id, 'vote' => 4])}}"
                                        @else
                                        href="#"    
                                        @endif
                                        title="great">★</a>
                                        <a
                                        @if ($isLogin)
                                        href="{{route('vote', ['id' => $blog->id, 'vote' => 5])}}"
                                        @else
                                        href="#"    
                                        @endif
                                        title="awesome">★</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                @if ($before > 0)
                                    <a href="{{route('main.read', ['id' => $before])}}" class="btn btn-success">Önceki Blog</a>
                                @endif
                                @if ($after > 0)
                                    <a href="{{route('main.read', ['id' => $after])}}" class="btn btn-danger">Sonraki Blog</a>
                                @endif
                            </div>
        
                    </div>
                </div>

            </div>
        </div>
@endsection
   