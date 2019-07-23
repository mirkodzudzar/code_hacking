@extends('layouts.admin')

@section('content')

  @if(Session::has('created_post'))
    <div class="alert alert-success">
      <p>{{session('created_post')}}</p>
    </div>
  @elseif(Session::has('updated_post'))
    <div class="alert alert-success">
      <p>{{session('updated_post')}}</p>
    </div>
  @elseif(Session::has('deleted_post'))
    <div class="alert alert-success">
      <p>{{session('deleted_post')}}</p>
    </div>
  @endif

  <h1>Posts</h1>

  <table class="table">
  <thead>
    <tr>
      <th>Id</th>
      <th>Photo</th>
      <th>User</th>
      <th>Category</th>
      <th>Title</th>
      <th>Post link</th>
      <th>Comments</th>
      <th>Created</th>
      <th>Updated</th>
    </tr>
  </thead>
  <tbody>
    @if($posts)
      @foreach($posts as $post)
        <tr>
          <td>{{$post->id}}</td>
          <td><img height="50" src="{{$post->photo ? $post->photo->file : App\Photo::noImage()}}" alt=""></td>
          <td><a href="{{route('admin.posts.edit', $post->id)}}">{{$post->user->name}}</a></td>
          <td>{{$post->category ? $post->category->name : 'Uncategorized'}}</td>
          <td>{{$post->title}}</td>
          <td><a href="{{route('home.post', $post->slug)}}">View post</a></td>
          <td><a href="{{route('admin.comments.show', $post->id)}}">View comments</a></td>
          <td>{{$post->created_at->diffForHumans()}}</td>
          <td>{{$post->updated_at->diffForHumans()}}</td>
        </tr>
      @endforeach
    @endif
  </tbody>
</table>

<div class="row">
  <div class="col-xs-6 col-xs-offset-5">
    {{$posts->render()}}
  </div>
</div>

@endsection
