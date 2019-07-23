@extends('layouts.admin')

@section('content')

  <h1>Media</h1>

  @if(Session::has('deleted_photo'))
    <div class="alert alert-success">
      <p>{{session('deleted_photo')}}</p>
    </div>
  @elseif(Session::has('more_photos_deleted'))
    <div class="alert alert-success">
      <p>{{session('more_photos_deleted')}}</p>
    </div>
  @endif

  @if($photos)

    <form action="delete/media" method="post" class="form-inline">

      {{csrf_field()}}
      {{method_field('delete')}}

      <div class="form-group">
        <select name="checkBoxArray" class="form-control">
          <option value="">Delete</option>
        </select>
      </div>
      <div class="form-group">
        <input type="submit" name="delete_all" class="btn btn-primary" name="">
      </div>

      <table class="table">
        <thead>
          <tr>
            <th><input type="checkbox" id="options"></th>
            <th>Id</th>
            <th>Name</th>
            <th>Created</th>
            <th>Updated</th>
          </tr>
        </thead>
        <tbody>
          @foreach($photos as $photo)
            <tr>
              @if($photo->id != 1)
                @if($photo->user)
                <td><i>user's picture</i></td>
                @elseif($photo->post)
                <td><i>post's picture</i></td>
                @else
                <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="{{$photo->id}}"></td>
                @endif
              @else
                <td></td>
              @endif
              <td>{{$photo->id}}</td>
              <td><img height="50" src="{{$photo->file}}" alt=""></td>
              <td>{{$photo->created_at ? $photo->created_at->diffForHumans() : 'no date'}}</td>
              <td>{{$photo->updated_at ? $photo->updated_at->diffForHumans() : 'no date'}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </form>
  @endif

@endsection

@section('scripts')

    <script>

        $(document).ready(function(){

            $('#options').click(function(){

                if(this.checked){

                    $('.checkBoxes').each(function(){

                        this.checked = true;

                    });
                }else {

                    $('.checkBoxes').each(function(){

                        this.checked = false;

                    });
                }
            });
        });

    </script>

@endsection
