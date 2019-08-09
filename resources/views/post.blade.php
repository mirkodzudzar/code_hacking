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
          <p class="lead">by {{$post->user->name}}</p>
        @endif

      @else
        <h1>{{$post->title}}</h1>
        <p class="lead">by {{$post->user->name}}</p>
      @endif

      <hr>

      <!-- Date/Time -->
      <p><span class="glyphicon glyphicon-time"></span> Posted {{$post->created_at->diffForHumans()}} | <i><a href="#comments" onclick="Scroll1('comments')">{{$countComments > 1 ? $countComments." comments" : $countComments." comment"}} | </a></i>

        <a href="{{route('home.post.like', $post->slug)}}">
          <span class="fa fa-thumbs-up">Like ({{$countLikes}})</span>
        </a>
        <a href="{{route('home.post.dislike', $post->slug)}}">
          <span class="fa fa-thumbs-down">Dislike ({{$countDislikes}})</span>
        </a>

      </p>
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
              {!! Form::submit('Submit comment', ['class' => 'btn btn-primary', 'onClick' => 'return ConfirmSubmitComment();']) !!}
            </div>

          {!! Form::close() !!}

      </div>

      @endif

      <hr>

      <!-- Posted Comments -->

      @forelse($comments as $comment)

        <!-- Comment -->
        <div class="media" id="comments">
            <a class="pull-left" href="#">
                <img height="64" class="media-object" src="{{$comment->photo ? $comment->photo : App\Photo::noImage()}}" alt="">
            </a>
            <div class="media-body">
                <h4 class="media-heading">{{$comment->author}}
                    <small>{{$comment->created_at->diffForHumans()}}</small>
                </h4>
                <p>{{$comment->body}}</p>

                  <div class="comment-reply-container">

                    @if(Auth::check())

                      <button class="toggle-reply btn btn-primary pull-right" type="button" name="button">Reply</button>

                    @endif

                    <div class="comment-reply col-xs-10">

                      {!! Form::open(['method'=>'POST', 'action'=> 'CommentRepliesController@createReply']) !!}
                           <div class="form-group">

                               <input type="hidden" name="comment_id" value="{{$comment->id}}">

                               {!! Form::textarea('body', null, ['class'=>'form-control','rows'=>1])!!}
                           </div>

                           <div class="form-group">
                               {!! Form::submit('Submit', ['class'=>'btn btn-primary', 'onClick' => 'return ConfirmSubmitReply();']) !!}
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
        <hr>
      @empty
        <h3 class="text-center">No comments found</h3>
      @endforelse
    </div><!-- col-mid-8 -->

    @include('includes.front_sidebar')

  </div><!-- ROW -->

@endsection

@section('scripts')

  <script>

    $('.toggle-reply').on('click', function() {

        $(this).next().slideToggle('slow');

    });

    function ConfirmSubmitComment()
    {
      var x = confirm("Are you sure you want to post a comment?");
      if(x)
        return true;
      else
        return false;
    }

    function ConfirmSubmitReply()
    {
      var x = confirm("Are you sure you want to post a reply?");
      if(x)
        return true;
      else
        return false;
    }

    function Scroll() {
    	var top = document.getElementById("navigation");
    	var ypos = window.pageYOffset;
    	if(ypos > 50) {
    		top.style.opacity = "0";
    	} else {
    		top.style.opacity = "1";
    	}
    }

    window.addEventListener("scroll",Scroll);


    var marginY = 0;
    var destination = 0;
    var speed = 10;
    var scroller = null;

    function Scroll1(elementName) {
    	destination = document.getElementById(elementName).offsetTop;

    	scroller = setTimeout(function() {
    		Scroll1(elementName);
    	}, 1);

    	marginY = marginY + speed;

    	if(marginY >= destination) {
    		clearTimeout(scroller);
    	}

    	window.scroll(0, marginY);
    }

  </script>

@endsection
