@extends('layouts.admin')

@section('content')

  <h1>Posts</h1>

  <table class="table">
  <thead>
    <tr>
      <th>Id</th>
      <th>Photo</th>
      <th>Title</th>
      <th>User</th>
      <th>Category</th>
      <th>Post link</th>
      <th>Comments</th>
      <th>Created</th>
      <th>Updated</th>
    </tr>
  </thead>
  <tbody>
    @forelse($posts as $post)
      <tr>
        <td>{{$post->id}}</td>
        <td><img height="50" src="{{$post->photo ? $post->photo->file : App\Photo::noImage()}}" alt=""></td>
        <td><a href="{{route('admin.posts.edit', $post->id)}}">{{$post->title}}</a></td>
        <td>{{$post->user->name}}</td>
        <td>{{$post->category ? $post->category->name : 'Uncategorized'}}</td>
        <td><a href="{{route('home.post', $post->slug)}}">View post</a></td>
        <td><a href="{{route('admin.comments.show', $post->id)}}">View comments</a></td>
        <td>{{$post->created_at->diffForHumans()}}</td>
        <td>{{$post->updated_at->diffForHumans()}}</td>
      </tr>
    @empty
      <tr>
        <th>No posts found</th>
      </tr>
    @endforelse
  </tbody>
</table>

<div class="row">
  <div class="col-xs-6 col-xs-offset-5">
    {{$posts->render()}}
  </div>
</div>

@endsection
