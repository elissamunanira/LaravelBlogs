@extends ("layouts.app");

@section('content')

  <h1>Edit Post</h1>

  <form action="{{ url('posts/'.$post->id) }}" method="post" enctype="multipart/form-data">
     {{csrf_field()}}
     @method("PATCH")
         <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title',$post->title ,['class' => 'form-control', 'placeholder' => 'Title'])}}
         </div>

         <div class="form-group">
           {{ Form::label('body', 'Body')}}
            {{Form::textarea('body',$post->body ,['id'=> 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body'])}}
         </div>
         <div class="form-group">
            {{Form::file('cover_image')}}
         </div>
         {{Form::submit('Submit' , ['class' => 'btn btn-primary'])}}
  </form>
@endsection

{{-- @extends('layouts.app')

@section('content')
    <h1>Create Post</h1>
    <form action= "{{url('PostsController@update '.$post->id)}}" method="post">
        {!! csrf_field() !!}
        @method("PUT")
        <label>Title</label></br>
        <input type="text" name="title" id="title" value="{{$post->title}}"class="form-control"></br>
        <label>Body</label></br>
        <input type="textarea" name="body" id="address" value="{{$post->body}}"class="form-control"></br>
        <input type="submit" value="Upload" class="btn btn-success"></br>
    </form>
@endsection--}}

{{-- @extends('layouts.app')
@section('content')
<div class="card">
  <div class="card-header">Contactus Page</div>
  <div class="card-body">

      <form action="{{ url('posts/' .$post->id) }}" method="post">
        {!! csrf_field() !!}
        @method("PATCH")
        <label>title</label></br>
        <input type="text" name="id" id="id" value="{{$post->title}}" class="form-control"id="id" /><br>
        <label>Name</label></br>
        <input type="text" name="name" id="name" value="{{$post->body}}" class="form-control"></br>
        <input type="submit" value="Update" class="btn btn-success"></br>
    </form>

  </div>
</div>
@stop --}}

