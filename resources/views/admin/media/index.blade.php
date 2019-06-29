@extends('layouts.admin')

@section('content')

  <h1>Media</h1>

  @if(Session::has('deleted_photo'))
    <div class="alert alert-success">
      <p>{{session('deleted_photo')}}</p>
    </div>
  @endif

  @if($photos)

    <table class="table">
      <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Created</th>
          <th>Updated</th>
        </tr>
      </thead>
      <tbody>
        @foreach($photos as $photo)
          <tr>
            <td>{{$photo->id}}</td>
            <td><img height="50" src="{{$photo->file}}" alt=""></td>
            <td>{{$photo->created_at ? $photo->created_at->diffForHumans() : 'no date'}}</td>
            <td>{{$photo->updated_at ? $photo->updated_at->diffForHumans() : 'no date'}}</td>
            <td>
              @if($photo->id !== 1)
                {!! Form::open(['method' => 'DELETE', 'action' => ['AdminMediasController@destroy', $photo->id]]) !!}

                <div class="form-group">
                  {!! Form::submit('Delete photo', ['class' => 'btn btn-danger']) !!}
                </div>

                {!! Form::close() !!}
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

  @endif

@endsection
