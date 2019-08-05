@if(Session::has('created_category'))
  <div class="alert alert-success">
    <p>{{session('created_category')}}</p>
  </div>

@elseif(Session::has('updated_category'))
  <div class="alert alert-success">
    <p>{{session('updated_category')}}</p>
  </div>

@elseif(Session::has('deleted_category'))
  <div class="alert alert-success">
    <p>{{session('deleted_category')}}</p>
  </div>

@elseif(Session::has('reply_updated'))
  <div class="alert alert-success">
    <p>{{session('reply_updated')}}</p>
  </div>

@elseif(Session::has('reply_deleted'))
  <div class="alert alert-success">
    <p>{{session('reply_deleted')}}</p>
  </div>

@elseif(Session::has('comment_updated'))
  <div class="alert alert-success">
    <p>{{session('comment_updated')}}</p>
  </div>

@elseif(Session::has('comment_deleted'))
  <div class="alert alert-success">
    <p>{{session('comment_deleted')}}</p>
  </div>

@elseif(Session::has('comment_updated'))
  <div class="alert alert-success">
    <p>{{session('comment_updated')}}</p>
  </div>

@elseif(Session::has('comment_deleted'))
  <div class="alert alert-success">
    <p>{{session('comment_deleted')}}</p>
  </div>

@elseif(Session::has('deleted_photo'))
  <div class="alert alert-success">
    <p>{{session('deleted_photo')}}</p>
  </div>

@elseif(Session::has('more_photos_deleted'))
  <div class="alert alert-success">
    <p>{{session('more_photos_deleted')}}</p>
  </div>

@elseif(Session::has('created_post'))
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

@elseif(Session::has('created_user'))
  <div class="alert alert-success">
    <p>{{session('created_user')}}</p>
  </div>

@elseif(Session::has('updated_user'))
  <div class="alert alert-success">
    <p>{{session('updated_user')}}</p>
  </div>

@elseif(Session::has('deleted_user'))
  <div class="alert alert-success">
    <p>{{session('deleted_user')}}</p>
  </div>
  
@endif
