@extends('layouts.admin')

@section('content')

  <div class="well">
      <h4>Search Posts</h4>
      <form class="" action="{{URL::to('/admin/posts/search')}}" method="POST" role="search">
        {{csrf_field()}}
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Enter post name">
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
              <th>Title</th>
              <th>Author</th>
            </tr>
          </thead>
          <tbody>
            @foreach($details as $post)
              <tr>
                <td><a href="{{route('admin.posts.edit', $post->id)}}">{{$post->title}}</a></td>
                <td>{{$post->user->name}}</td>
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
      <!-- /.input-group -->
  </div>

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
