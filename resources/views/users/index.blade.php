@extends('layouts.app')
@section('title', 'Users')
@section("content")
<div class="container">
  <div class="row pull-right">
    <a href="{{ url('/create_new_author') }}" class="btn btn-info">Create New Author&nbsp;<i class="fa fa-plus"></i></a>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <h3><i class="fa fa-user"></i>&nbsp;Author Details:</h3>
      <table class="table table-bordered table-hover table-striped">
        <thead>
          <tr>
            <th>Author Name</th>
            <th>Email ID</th>
            <th>Phone Number</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $author)
          <tr>
            <td>{{$author->name}}</td>
            <td>{{$author->email}}</td>
            <td>{{$author->phone}}</td>
              <td>
              <a href="/edit_author/{{$author->id}}" class="btn publish_btn">
                <i class="fa fa-edit"></i>
              </a>
              <a type="button" class="delete_author_modal btn publish_btn" data-toggle="modal" data-target="#myModal" id="{{$author->id}}"><i class="fa fa-trash"></i></a>    
            </td>
          </tr>

              <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-trash"></i>&nbsp;Delete Author</h4>
                    </div>
                    <div class="modal-body">
                      <p>Are you sure, you want to delete this Author?</p>
                    </div>
                    <div class="modal-footer">
                      <a class="delete_author_modal_btn" href="{{ url('/delete_author') }}/{{ $author->id }}" class="btn publish_btn" id="{{$author->id}}"><i class="fa fa-trash"></i></a>
                    </div>
                  </div>

                  </div>
                </div>
          @endforeach
        </tbody>
      </table>      
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function() {
      $(".delete_author_modal").click(function() {
        author_id = $(this)[0].id
        href_url = "{{url('/delete_author')}}/"+author_id+"/"
        $("#myModal .delete_author_modal_btn").attr("href", href_url)
      })    
  })
</script>
@endsection
