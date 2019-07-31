@extends('layouts.admin')

@section('content')

  @if(Session::has('comment_updated'))
    <div class="alert alert-success">
      <p>{{session('comment_updated')}}</p>
    </div>
  @elseif(Session::has('comment_deleted'))
    <div class="alert alert-success">
      <p>{{session('comment_deleted')}}</p>
    </div>
  @endif

  <h1>Comments</h1>

  <table class="table">
    <thead>
      <tr>
        <th>Id</th>
        <th>Author</th>
        <th>Email</th>
        <th>Body</th>
      </tr>
    </thead>
    <tbody>
      @forelse($comments as $comment)
        <tr>
          <td>{{$comment->id}}</td>
          <td>{{$comment->author}}</td>
          <td>{{$comment->email}}</td>
          <td>{{str_limit($comment->body, $limit = 25, $end = '...')}}</td>
          <td><a href="{{route('home.post', $comment->post->slug)}}">View post</a></td>
          <td><a href="{{route('admin.comment.replies.show', $comment->id)}}">View replies</a></td>
          <td>

            @if($comment->is_active == 1)
              {!! Form::open(['method' => 'PATCH', 'action' => ['PostCommentsController@update', $comment->id]]) !!}

                <input type="hidden" name="is_active" value="0">

                <div class="form-group">
                  {!! Form::submit('Un-approve', ['class' => 'btn btn-success']) !!}
                </div>
              {!! Form::close() !!}
            @else
              {!! Form::open(['method' => 'PATCH', 'action' => ['PostCommentsController@update', $comment->id]]) !!}

                <input type="hidden" name="is_active" value="1">

                <div class="form-group">
                  {!! Form::submit('Approve', ['class' => 'btn btn-info']) !!}
                </div>
              {!! Form::close() !!}
            @endif

          </td>
          <td>

            {!! Form::open(['method' => 'DELETE', 'action' => ['PostCommentsController@destroy', $comment->id]]) !!}

              <div class="form-group">
                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
              </div>
            {!! Form::close() !!}

          </td>
        </tr>
      @empty
        <tr>
          <th>No comments found</th>
        </tr>
      @endforelse
    </tbody>
  </table>

@endsection
