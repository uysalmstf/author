<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('stars.css')}}">

</head>
  <body>
    <div class="container">
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
                                        href="http://localhost:8008/author/public/vote/<?=$blog->id?>/1"
                                        @else
                                        href="#"    
                                        @endif
                                         title="awful">★</a>
                                        <a
                                        @if ($isLogin)
                                        href="http://localhost:8008/author/public/vote/<?=$blog->id?>/2"
                                        @else
                                        href="#"    
                                        @endif
                                         title="ok">★</a>
                                        <a
                                        @if ($isLogin)
                                        href="http://localhost:8008/author/public/vote/<?=$blog->id?>/3"
                                        @else
                                        href="#"    
                                        @endif
                                         title="good">★</a>
                                        <a
                                        @if ($isLogin)
                                        href="http://localhost:8008/author/public/vote/<?=$blog->id?>/4"
                                        @else
                                        href="#"    
                                        @endif
                                        title="great">★</a>
                                        <a
                                        @if ($isLogin)
                                        href="http://localhost:8008/author/public/vote/<?=$blog->id?>/5"
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
    </div>
  </body>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
<script>
</script>
</html>