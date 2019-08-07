<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form class="" action="{{URL::to('/search')}}" method="POST" role="search">
          {{csrf_field()}}
          <div class="input-group">
              <input type="text" name="query" class="form-control" placeholder="Search some post">
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
                  <td><a href="{{route('home.post', $post->slug)}}">{{$post->title}}</a></td>
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

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-unstyled">
                  @forelse($categories as $category)
                    @if(!Auth::guest())

                      @if(Auth::user()->role_id && Auth::user()->is_active)

                        @if(Auth::user()->isAdmin())
                          <li><a href="{{route('admin.categories.edit', $category->id)}}">{{$category->name}}</a></li>
                        @else
                          <li>{{$category->name}}</li>
                        @endif

                      @else
                        <li>{{$category->name}}</li>
                      @endif

                    @else
                      <li>{{$category->name}}</li>
                    @endif
                  @empty
                    <p>No categories found</p>
                  @endforelse
                </ul>
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <!-- <div class="well">
        <h4>Side Widget Well</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
    </div> -->

</div>
