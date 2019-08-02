@if(Session::has('comment_message'))
  <div class="alert alert-success">
    <p>{{session('comment_message')}}</p>
  </div>
@elseif(Session::has('reply_message'))
  <div class="alert alert-success">
    <p>{{session('reply_message')}}</p>
  </div>
@endif
