@extends('layouts.blog-home')

@section('content')

  <div class="row">
    <div class="col-md-8">

      <!-- Blog Post -->

      @if(!Auth::guest())

        @if(Auth::user()->isAdmin())
          <!-- Title -->
          <h1><a href="{{route('admin.posts.edit', $post->id)}}">{{$post->title}}</a></h1>
          <p class="lead">by <a href="{{route('admin.users.edit', $post->user->id)}}">{{$post->user->name}}</a></p>
        @else
          <h1>{{$post->title}}</h1>
          <p class="lead">{{$post->user->name}}</p>
        @endif

      @else
        <h1>{{$post->title}}</h1>
        <p class="lead">{{$post->user->name}}</p>
      @endif

      <hr>

      <!-- Date/Time -->
      <p><span class="glyphicon glyphicon-time"></span> Posted {{$post->created_at->diffForHumans()}}</p>

      <hr>

      <!-- Preview Image -->
      <img class="img-responsive" src="{{$post->photo ? $post->photo->file : App\Photo::noPostImage()}}" alt="">

      <hr>

      <!-- Post Content -->

      <p>{!! $post->body !!}</p>

      <hr>

      <!-- Blog Comments -->

      @if(Auth::check())

      <!-- Comments Form -->
      <div class="well">
          <h4>Leave a Comment:</h4>

          {!! Form::open(['method' => 'POST', 'action' => 'PostCommentsController@store']) !!}

            <input type="hidden" name="post_id" value="{{$post->id}}">

            <div class="form-group">
              {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 3]) !!}
            </div>

            <div class="form-group">
              {!! Form::submit('Submit comment', ['class' => 'btn btn-primary']) !!}
            </div>

          {!! Form::close() !!}

      </div>

      @endif

      <hr>

      <!-- Posted Comments -->

      @forelse($comments as $comment)

        <!-- Comment -->
        <div class="media">
            <a class="pull-left" href="#">
                <img height="64" class="media-object" src="{{$comment->photo ? $comment->photo : App\Photo::noImage()}}" alt="">
            </a>
            <div class="media-body">
                <h4 class="media-heading">{{$comment->author}}
                    <small>{{$comment->created_at->diffForHumans()}}</small>
                </h4>
                <p>{{$comment->body}}</p>

                <div class="comment-reply-container">

                  <button class="toggle-reply btn btn-primary pull-right" type="button" name="button">Reply</button>

                  <div class="comment-reply col-xs-10">

                    {!! Form::open(['method'=>'POST', 'action'=> 'CommentRepliesController@createReply']) !!}
                         <div class="form-group">

                             <input type="hidden" name="comment_id" value="{{$comment->id}}">

                             {!! Form::textarea('body', null, ['class'=>'form-control','rows'=>1])!!}
                         </div>

                         <div class="form-group">
                             {!! Form::submit('Submit', ['class'=>'btn btn-primary']) !!}
                         </div>
                    {!! Form::close() !!}

                </div>
            </div>

                @foreach($comment->replies as $reply)

                  @if($reply->is_active == 1)

                    <!-- Nested Comment -->
                    <div id="nested-comment" class="media">
                        <a class="pull-left" href="#">
                            <img height="64" class="media-object" src="{{$reply->photo ? $reply->photo : App\Photo::noImage()}}" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">{{$reply->author}}
                                <small>{{$reply->created_at->diffForHumans()}}</small>
                            </h4>
                          <p>{{$reply->body}}</p>
                        </div>

                    <!-- End Nested Comment -->
                    </div>

                  <!-- else -->

                    <!-- <div id="no_reply" class="text-center">
                      <p>No replies</p>
                    </div> -->

                  @endif
                @endforeach
            </div>
        </div>
      @empty
        <h3 class="text-center">No comments found</h3>
      @endforelse
    </div><!-- col-mid-8 -->

    @include('includes.front_sidebar')

  </div><!-- ROW -->

@endsection

@section('scripts')

  <script>

      $(".comment-reply-container .toggle-reply").click(function(){

          $(this).next().slideToggle("slow");

      });

  </script>

@endsection
