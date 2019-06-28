@extends('layouts.admin')

@section('content')

  <h1>Categories</h1>

  <div class="col-xs-6">

    {!! Form::model($category, ['method' => 'PATCH', 'action' => ['AdminCategoriesController@update', $category->id]]) !!}

      <div class="form-group">
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
      </div>

      <div class="form-group">
        {!! Form::submit('Edit category', ['class' => 'btn btn-primary col-xs-6']) !!}
      </div>

    {!! Form::close() !!}

    {!! Form::open(['method' => 'DELETE', 'action' => ['AdminCategoriesController@destroy', $category->id]]) !!}

      <div class="form-group">
        {!! Form::submit('Delete category', ['class' => 'btn btn-danger col-xs-6']) !!}
      </div>

    {!! Form::close() !!}

  </div>



  </div>

@endsection
