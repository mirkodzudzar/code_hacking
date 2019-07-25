@extends('layouts.admin')

@section('content')

    @if(Session::has('created_user'))
      <div class="alert alert-success">
        <p>{{session('created_user')}}</p>
      </div>
    @elseif(Session::has('updated_user'))
      <div class="alert alert-success">
        <p>{{session('updated_user')}}</p>
      </div>
    @elseif(Session::has('deleted_user'))
      <div class="alert alert-success">
        <p>{{session('deleted_user')}}</p>
      </div>
    @endif

    <h1>Users</h1>

    <table class="table">
    <thead>
      <tr>
        <th>Id</th>
        <th>Photo</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Status</th>
        <th>Created</th>
        <th>Updated</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $user)
        <tr>
          <td>{{$user->id}}</td>
          <td><img height="50" src="{{$user->photo ? $user->photo->file : App\Photo::noImage()}}" alt=""></td>
          <!-- we can add opt value 'opt' => 'a'-->
          <td><a href="{{route('admin.users.edit', $user->id)}}">{{$user->name}}</a></td>
          <td>{{$user->email}}</td>
          <td>{{$user->role['name'] == null ? 'User has no role':$user->role['name']}}</td>
          <td>{{$user->is_active == 1 ? 'Active':'Not Active'}}</td>
          <td>{{$user->created_at->diffForHumans()}}</td>
          <td>{{$user->updated_at->diffForHumans()}}</td>
        </tr>
      @empty
        <tr>
          <th>No users found</th>
        </tr>
      @endforelse
    </tbody>
  </table>

@endsection
