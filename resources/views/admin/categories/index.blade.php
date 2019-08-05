@extends('layouts.admin')

@section('content')

  <h1>Categories</h1>

  <div class="col-xs-6">

    {!! Form::open(['method' => 'POST', 'action' => 'AdminCategoriesController@store']) !!}

      <div class="form-group">
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
      </div>

      <div class="form-group">
        {!! Form::submit('Create category', ['class' => 'btn btn-primary col-xs-6']) !!}
      </div>

    {!! Form::open() !!}

  </div>

  <div class="col-xs-6">

    <table class="table">
      <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Created</th>
        </tr>
      </thead>
      <tbody>
        @forelse($categories as $category)
          <tr>
            <td>{{$category->id}}</td>
            <td><a href="{{ route('admin.categories.edit', $category->id) }}">{{$category->name}}</a></td>
            <td>{{$category->created_at ? $category->created_at->diffForHumans() : 'no date'}}</td>
          </tr>
        @empty
          <tr>
            <th>No category found</th>
          </tr>
        @endforelse
      </tbody>
    </table>

  </div>

@endsection
