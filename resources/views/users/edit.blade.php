@extends('layouts.app')

@section("content")
<div class="container">

  <div class="row">
      @if(count($errors) > 0)
        @foreach($errors->all() as $error)
        <div class="alert alert-danger">
          {{$error}}
        </div>
        @endforeach
      @endif  

      <div class="alert alert-success alert-dismissible success_msg" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Congratulations!&nbsp;</strong>your author updated successfully.
      </div>

      <ul class="errors" style="list-style-type: none;">   
      </ul>
      <ul style="list-style-type: none;">
        <li class="alert alert-warning article_exists_error"><span><b>Wait!</b>&nbsp;This article already exists!</span></li>
      </ul>


  <form id="update_author" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">   
      <div class="col-sm-offset-3 col-sm-6">
          <div class="form-group">
            <label>Full Name:</label>
            <input type="text" class="form-control" id="full_name" name="author_name" value="{{$user->name}}">
            <small><em><b>Input Full Name</b> Max Length : 150.</em></small>
          </div>
          <div class="form-group">
            <label><i class="fa fa-envelope"></i>&nbsp;Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}">
            <small><em><b>Format Email must</b> Valid Email, <b>Input Email</b> Max Length : 150.</em></small>          
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

// =======Creating an article through AJAX starts
        $('#update_author').on('submit', function(e) {
          // alert('update_categories')
            e.preventDefault();

            $.ajax({
              url: '{{url("/update_author")}}/{{$user->id}}',
              headers:{
                 'X-CSRF-TOKEN': "{{ csrf_token() }}"
               },   
              method: 'POST',
              type: 'JSON',
              data:  new FormData(this),
              contentType: false,
              cache: false,
              processData:false,
              beforeSend: function() {
                $('#loading_icon').show();
                $(".lds-css").show()
              },
              success: function(obj) {
                // console.log(obj);
                // $(".alert-danger").remove();
                count=0;
                for(i=0;i<obj.length;i++) {
                  if(obj[i]!='') {
                    count++;
                  }
                }
                // console.log(count)
                  if (obj.status == "success") {
                    $(".article_exists_error, .alert-danger").hide()
                    $(".success_msg").show()
                    setTimeout(()=>{
                      window.location = "{{url('/create_user')}}";
                    },3000);
                  }
                console.log(obj.status == "This article already exists!")
                  if (obj.status == "This article already exists!") {
                    $(".success_msg, .alert-danger").hide();
                    $(".article_exists_error").show()
                  }
              },
              error: function(obj) {
                $(".success_msg").hide();
                console.log(obj.responseJSON.errors)

                  $('.errors').show()
                  $(".errors").empty()
                $.each(obj.responseJSON.errors, function(key, val) {
                  // alert("ok")
                  $('.errors').append("<li class='alert alert-danger'>"+val+"</li>")
                });
              },
              complete: function() {
                $('#loading_icon',".lds-css").hide();
              }
            })

        })
// =======Creating an article through AJAX ends
  })
</script>
@endsection