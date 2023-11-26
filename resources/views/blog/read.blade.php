@extends('layouts.admin')
@section('content')
        <div class="card">

            <div class="card-header">Blog Gösterim</div>
            <div class="card-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" value="<?=$data->title?>">
                    </div>
                    <div class="form-group">
                        <label for="title">Body</label>
                        <textarea name="body" class="form-control" cols="30" rows="10"><?=$data->body?></textarea>
                    </div>
                    <div class="part">
                        <p>Oylama </p>
                        <div class="stars rate" data-percent="0">
                            <a href="{{route('vote', ['id' => $data->id, 'vote' => 1])}}" title="awful">★</a>
                            <a href="{{route('vote', ['id' => $data->id, 'vote' => 2])}}" title="ok">★</a>
                            <a href="{{route('vote', ['id' => $data->id, 'vote' => 3])}}" title="good">★</a>
                            <a href="{{route('vote', ['id' => $data->id, 'vote' => 4])}}" title="great">★</a>
                            <a href="{{route('vote', ['id' => $data->id, 'vote' => 5])}}" title="awesome">★</a>
                        </div>
                    </div>

            </div>
        </div>
    @endsection