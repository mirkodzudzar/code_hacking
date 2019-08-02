@extends('layouts.blog-home')

@section('content')

  <!-- Blog Entries Column -->
  <div class="col-md-8">

      <!-- First Blog Post -->

      @forelse($posts as $post)

        <h2>
            <a href="#">{{$post->title}}</a>
        </h2>
        <p class="lead">by {{$post->user->name}}</p>
        <p><span class="glyphicon glyphicon-time"></span>{{$post->created_at->diffForHumans()}}</p>
        <hr>
        <img class="img-responsive" src="http://placehold.it/900x300" alt="">
        <hr>
        <p>{{str_limit($post->body, $limit = 250)}}</p>
        <a class="btn btn-primary" href="{{route('home.post', $post->slug)}}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

        <hr>

      @empty

        <p>No posts found</p>

      @endforelse

      <!-- PAGINATION -->
      <div class="row">
        <div class="col-sm-6 col-sm-offset-5">
          {{$posts->render()}}
        </div>
      </div>


  </div>

  <!-- Blog Sidebar -->
  @include('includes.front_sidebar')

@endsection
