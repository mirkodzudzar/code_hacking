@extends('layouts.admin')

@section('content')

  @include('includes.tinyeditor')

  <h1>Edit Post</h1>

  <div class="col-xs-3">
    <img src="{{$post->photo->file}}" alt="" class="img-responsive img-rounded">
  </div>

  <div class="col-xs-9">

    @include('includes.errors')

    {!! Form::model($post, ['method' => 'PATCH', 'action' => ['AdminPostsController@update', $post->id], 'files' => true]) !!}

      <div class="form-group">
        {!! Form::label('title', 'Title:') !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('category_id', 'Category:') !!}
        {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('photo_id', 'Photo:') !!}
        {!! Form::file('photo_id', null, ['class' => 'form-control']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('body', 'Description:') !!}
        {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 3]) !!}
      </div>

      <div class="form-group">
        {!! Form::submit('Edit post', ['class' => 'btn btn-primary col-xs-6']) !!}
      </div>

    {!! Form::close() !!}

    {!! Form::open(['method' => 'DELETE', 'action' => ['AdminPostsController@destroy', $post->id]]) !!}
      <div class="form-group">
        {!! Form::submit('Delete post', ['class' => 'btn btn-danger col-xs-6']) !!}
      </div>
    {!! Form::close() !!}

  </div>

@endsection
