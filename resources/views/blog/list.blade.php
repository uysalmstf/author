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
                @foreach ($blogs as $item)
                <div class="card">
                    <div class="card-header" style="cursor: pointer;"><a href="{{route('main.read', ['id' => $item['id']])}}">{{$item['title']}}</a></div>
                    <div class="card-body">
                        {{$item['body']}}
                    </div>
                </div>
                @endforeach
               

            </div>
        </div>
        @endsection