@extends('layouts.admin')

@section('content')

  @if(Session::has('reply_updated'))
    <div class="alert alert-success">
      <p>{{session('reply_updated')}}</p>
    </div>
  @elseif(Session::has('reply_deleted'))
    <div class="alert alert-success">
      <p>{{session('reply_deleted')}}</p>
    </div>
  @endif

  <h1>Replies</h1>

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
      @forelse($replies as $reply)
        <tr>
          <td>{{$reply->id}}</td>
          <td>{{$reply->author}}</td>
          <td>{{$reply->email}}</td>
          <td>{{$reply->body}}</td>
          <td><a href="{{route('home.post', $reply->comment->post->slug)}}">View post</a></td>
          <td>

            @if($reply->is_active == 1)
              {!! Form::open(['method' => 'PATCH', 'action' => ['CommentRepliesController@update', $reply->id]]) !!}

                <input type="hidden" name="is_active" value="0">

                <div class="form-group">
                  {!! Form::submit('Un-approve', ['class' => 'btn btn-success']) !!}
                </div>
              {!! Form::close() !!}
            @else
              {!! Form::open(['method' => 'PATCH', 'action' => ['CommentRepliesController@update', $reply->id]]) !!}

                <input type="hidden" name="is_active" value="1">

                <div class="form-group">
                  {!! Form::submit('Approve', ['class' => 'btn btn-info']) !!}
                </div>
              {!! Form::close() !!}
            @endif

          </td>
          <td>

            {!! Form::open(['method' => 'DELETE', 'action' => ['CommentRepliesController@destroy', $reply->id]]) !!}

              <div class="form-group">
                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
              </div>
            {!! Form::close() !!}

          </td>
        </tr>
      @empty
        <tr>
          <th>No replies found</th>
        </tr>
      @endforelse
    </tbody>
  </table>

@endsection
