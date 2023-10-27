@extends("layouts.app")
@section("content")
  <div class="container"> 
    <form action="/store_trending_category" method="POST"  enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">   
      <div class="col-sm-offset-3 col-sm-6">
          <div class="form-group">
            <label>Trending Category</label>
            <input type="text" class="form-control" id="full_name" name="trending_category_title" placeholder="Catgory Title...">
            <small><em><b>Input Category Title</b> Max Length : 61.</em></small>
          </div>
      </div>
    </div>
    <center>    
      <button type="submit" class="btn btn-success">Submit</button>
    </center>
    </form>
  </div>
  <script type="text/javascript">
    $(function() {
      $("#user_category").select2()
    })
  </script>
@endsection