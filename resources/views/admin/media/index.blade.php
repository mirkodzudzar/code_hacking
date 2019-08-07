@extends('layouts.admin')

@section('content')

  <h1>Media</h1>

  <form action="delete/media" method="post" class="form-inline">

    {{csrf_field()}}
    {{method_field('delete')}}

    <div class="form-group">
      <select name="checkBoxArray" class="form-control">
        <option value="">Delete</option>
      </select>
    </div>
    <div class="form-group">
      <input type="submit" name="delete_all" class="btn btn-primary" name="" onClick="return ConfirmDelete();">
    </div>

    <table class="table">
      <thead>
        <tr>
          <th></th>
          <th><input type="checkbox" id="options"></th>
          <th>Id</th>
          <th>Name</th>
          <th>Created</th>
          <th>Updated</th>
        </tr>
      </thead>
      <tbody>
        @forelse($photos as $photo)
          <tr>
            <!-- loop variable within foreach and forelse with properties such as index, iteration, remaining, count, firts, last, depth, parent  -->
            <th>{{$loop->iteration}}</th>
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
        @empty
          <tr>
            <th>No photos found</th>
          </tr>
        @endforelse
      </tbody>
    </table>
  </form>

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

        function ConfirmDelete()
        {
          var x = confirm("Are you sure you want to delete photo(s)?");
          if (x)
              return true;
          else
            return false;
        }

    </script>

@endsection
