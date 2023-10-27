@extends("layouts.app")

@section('content')  
  <div class="container">
  <div class="row">
      @if(count($errors) > 0)
        @foreach($errors->all() as $error)
        <div class="alert alert-danger">
          {{$error}}
        </div>
        @endforeach
      @endif


      @if(session('success'))
        <div class="alert alert-success">
          {{session('success')}}
        </div>
      @endif
      

<!-- ===Article create Success message begins===-->

      <div class="alert alert-success alert-dismissible success_msg" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Congratulations!&nbsp;</strong>your category updated successfully.
      </div>

<!-- ===Article create Success message ends===-->

<!-- ===Article create Errors message begins===-->

      <ul class="errors" style="list-style-type: none;">   
      </ul>

      <ul class="alert alert-danger message" style="list-style-type: none;">
      </ul>

      <ul class="alert alert-danger alert_summary_error_message" style="list-style-type: none;">      
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-danger heading_length_errors"><strong>Wait!</strong> Article Heading length exceeded to more than 12 words.</li>
      </ul>
      
      <ul style="list-style-type: none;">
        <li class="alert alert-danger summary_length_errors"><strong>Wait!</strong> Article Summary length exceeded to more than 70 words.</li>
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-danger article_heading_char_count_error"><span><b>Wait!</b>&nbsp;Article heading cannot be more than 65 characters.</span></li>
      </ul>    
      
      <ul style="list-style-type: none;">
        <li class="alert alert-danger article_summary_char_count_error"><span><b>Wait!</b>&nbsp;Article summary cannot be more than 485 characters.</span></li>
      </ul>
      
      <ul style="list-style-type: none;">
        <li class="alert alert-danger main_source_errors"><span><b>Wait!</b>&nbsp;Main source should be a valid URL.</span></li>
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-danger additional_source_errors"><span><b>Wait!</b>&nbsp;Additional source should be a valid URL.</span></li>
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-warning article_exists_error"><span><b>Wait!</b>&nbsp;This article already exists!</span></li>
      </ul>

<!-- ===Article create Errors message ends===-->    
  </div>
  <div class="row">
    <h4>
      <img src="{{ url('/assets/imgs/create_article.png') }}" alt="Create Article Image" title="Create an Article" width="30">
    <b>Edit Articles</b></h4>
    <div id="alert_message" class="alert alert-danger alert-dismissible" role="alert">
      <strong>Wait!</strong> <span class="message"></span>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    
    @if(isset($create_article_validation_flag))
      @foreach($validation_error_list as $error)
        <div id="alert_message" class="alert alert-danger alert-dismissible" role="alert">
          <strong>Wait!</strong> <span class="message">{{$error}}</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

      @endforeach
    @endif

</div>

<div class="row">
    <form id="update_category" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">   
      <div class="col-sm-offset-3 col-sm-6">
          <div class="form-group">
            <label>Category Title:</label>
            <input type="text" class="form-control" id="full_name" name="category_title" placeholder="Catgory Title..." value="{{$category->category_title}}">
            <small><em><b>Input Category Title</b> Max Length : 61.</em></small>
          </div>
          <div class="form-group">
            <label>Category Image:</label>
            <img src="{{ url('/') }}/{{$category->category_image_path}}" width="250">
            <input type="file" class="form-control" name="category_image">
            <small><em><b>Extension file must</b> JPG,PNG, <b>Max dimension</b> 500 * 500.</em></small>         
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



// =======Creating an article through AJAX starts
        $('#update_category').on('submit', function(e) {
          // alert('update_categories')
            e.preventDefault();

            $.ajax({
              url: '{{url("/update_categories")}}/{{$category->id}}',
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