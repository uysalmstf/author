@extends('layouts.admin')
@section('content')
     <div class="card">

            <div class="card-header">Blog Ekleme</div>
            <div class="card-body">
                <form action="{{route('create')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="title">Body</label>
                        <textarea name="body" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>

            </div>
        </div>
@endsection
       
    @endsection