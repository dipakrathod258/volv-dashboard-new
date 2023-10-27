@extends("layouts.app")

@section('content')
<div class="container"> 
  <div class="row">
      @if(count($errors) > 0)
        @foreach($errors->all() as $error)
        <div class="alert alert-danger">
          {{ $error }}
        </div>
        @endforeach
      @endif  

      <div class="alert alert-success alert-dismissible success_msg" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Congratulations!&nbsp;</strong>Your Publisher submitted successfully.
      </div>

      <ul class="errors" style="list-style-type: none;">   
      </ul>
      <ul style="list-style-type: none;">
        <li class="alert alert-warning article_exists_error"><span><b>Wait!</b>&nbsp;This article already exists!</span></li>
      </ul>
  </div>
  <div class="row">
    <h3>Create Publishers</h3>
  </div>
  <div class="row">
    <form action="{{ url('/save/publisher') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">   
      <div class="col-sm-offset-3 col-sm-6">
          <div class="form-group">
            <label>Publisher Title:</label>
            <input type="text" class="form-control" id="full_name" name="publisher_title" placeholder="Publisher Title...">
            <small><em><b>Input Publisher Title</b> Max Length : 61.</em></small>
          </div>

          <div class="form-group">
            <label>Publisher Image Path:</label>
<!--             <textarea class="form-control" name="publisher_image_path">
              
            </textarea>
 -->            <input class="form-control" type="file" name="publisher_image">
          </div>

          <div class="form-group">
            <label>Publisher Content:</label>
            <textarea class="form-control" placeholder="Enter Publisher Content..." name="publisher_content"></textarea>
            <small><em><b>Input Category Title</b> Max Length : 61.</em></small>
          </div>

      </div>

    </div>
      <center>    
        <button type="submit" class="btn btn-success">Submit</button>
      </center>
    </form>   
  </div>
</div>

@endsection