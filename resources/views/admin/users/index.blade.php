@extends('layouts.admin')

@section('content')

  <div class="well">
    <h4>Search users</h4>
    <form class="" action="{{URL::to('/admin/users/search')}}" method="POST" role="search">
      {{csrf_field()}}
      <div class="input-group">
          <input type="text" name="query" class="form-control" placeholder="Enter name or email">
          <span class="input-group-btn">
              <button class="btn btn-default" type="submit">
                  <span class="glyphicon glyphicon-search"></span>
              </button>
          </span>
      </div>
    </form>

    @if(isset($details))
    <div class="alert alert-dark">
      <p>The search results for your query <b> {{$query}} </b> are: </p>
      <table class="table table-stripped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          @foreach($details as $user)
            <tr>
              <td><a href="{{route('admin.users.edit', $user->id)}}">{{$user->name}}</a></td>
              <td>{{$user->email}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- When you search for empty string, it will not show a message -->
    @elseif(isset($message))
      <div class="alert alert-danger">
        <p>{{$message}}</p>
      </div>
    @endif
  </div>

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
