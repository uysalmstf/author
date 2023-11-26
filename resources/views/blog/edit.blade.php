@extends('layouts.admin')
@section('content')
        <div class="card">
            
            <div class="card-header">Blog Editleme</div>
            <div class="card-body">
                <form action="{{route('update', ['id' => $data->id])}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" value="<?=$data->title?>">
                    </div>
                    <div class="form-group">
                        <label for="title">Body</label>
                        <textarea name="body" class="form-control" cols="30" rows="10"><?=$data->body?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?=$data->id?>">
                        <button type="submit" class="btn btn-success">Edit</button>
                    </div>
                </form>

            </div>
        </div>
    @endsection