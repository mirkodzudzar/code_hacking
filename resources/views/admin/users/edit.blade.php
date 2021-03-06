@extends('layouts.admin')

@section('content')

  <h1>Edit Users</h1>

  <div class="col-xs-3">
    <img src="{{$user->photo ? $user->photo->file : App\Photo::noImage()}}" alt="" class="img-responsive img-rounded">
  </div>

  <div class="col-xs-9">

    <!-- Model method provides us data of a user that we ar updating. Form is already filled for us -->
    {!! Form::model($user, ['method' => 'PATCH', 'action' => ['AdminUsersController@update', $user->id], 'files' => true]) !!}

      <div class="form-group">
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('role_id', 'Role:') !!}
        {!! Form::select('role_id', $roles, null, ['class' => 'form-control']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('is_active', 'Status:') !!}
        {!! Form::select('is_active', array(1 => 'Active', 0 => 'Not Active'), null, ['class' => 'form-control']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('photo_id', 'Photo:') !!}
        {!! Form::file('photo_id', null, ['class' => 'form-control']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('password', 'Password:') !!}
        {!! Form::password('password', ['class' => 'form-control']) !!}
      </div>

      <div class="form-group">
        {!! Form::submit('Edit user', ['class' => 'btn btn-primary col-xs-6']) !!}
      </div>

    {!! Form::close() !!}

    {!! Form::open(['method' => 'DELETE', 'action' => ['AdminUsersController@destroy', $user->id]]) !!}

      <div class="form-group">
        {!! Form::submit('Delete user', ['class' => 'btn btn-danger col-xs-6', 'onClick' => 'return ConfirmDelete();']) !!}
      </div>

    {!! Form::close() !!}

  </div>

@endsection

@section('scripts')

  <script>

    function ConfirmDelete()
    {
      var x = confirm("Are you sure you want to delete {{$user->name}}?");
      if(x)
        return true;
      else
        return false;
    }

  </script>

@endsection
