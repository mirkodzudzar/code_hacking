@if(Session::has('comment_message'))
  <div class="alert alert-success">
    <p>{{session('comment_message')}}</p>
  </div>
@elseif(Session::has('reply_message'))
  <div class="alert alert-success">
    <p>{{session('reply_message')}}</p>
  </div>
@elseif(Session::has('liked_post'))
  <div class="alert alert-success">
    <p>{{session('liked_post')}}</p>
  </div>
@elseif(Session::has('disliked_post'))
  <div class="alert alert-success">
    <p>{{session('disliked_post')}}</p>
  </div>
@elseif(Session::has('canceled_liked_post'))
  <div class="alert alert-success">
    <p>{{session('canceled_liked_post')}}</p>
  </div>
@elseif(Session::has('canceled_disliked_post'))
  <div class="alert alert-success">
    <p>{{session('canceled_disliked_post')}}</p>
  </div>
@endif
