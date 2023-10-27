@extends('layouts.app')

@section('title', 'All Articles')

@section("all_article_internal_css")
<link href="{{ url('/assets/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
<script src="{{ url('/assets/js/bootstrap-datepicker.min.js') }}"></script>

<style type="text/css">
  html {
    scroll-behavior: smooth;
  }
  html.noscroll {
    position: fixed; 
    overflow-y: scroll;
    width: 100%;
}

  #nav-color-change {
    background-color: #337AB7;
    border: none;
    padding-bottom: 28px;
    /* width: 1840px; */
  }

  #button-color-change {
    background-color: #E8582B;
    border: none;
  }

  .pagination li {
    cursor: pointer;
  }

  #article_table .btn-primary {
    background-color: #FF7F50 !important;
    border-color: #FF7F50 !important;
  }

  .delete_article_success_msg {
    display: none;
  }

  .btn-edited,
  .btn-edited:hover,
  .btn-edited:focus {
    color: #fff;
    background-color: #a91b47;
  }

  .btn-republished,
  .btn-republished:hover,
  .btn-republished:focus {
    color: #fff;
    background-color: #286090;
  }


  /*--thank you pop starts here--*/
  .thank-you-pop {
    width: 100%;
    padding: 20px;
    text-align: center;
  }

  .thank-you-pop img {
    width: 76px;
    height: auto;
    margin: 0 auto;
    display: block;
    margin-bottom: 25px;
  }

  .thank-you-pop h1 {
    font-size: 42px;
    margin-bottom: 25px;
    color: #5C5C5C;
  }

  .thank-you-pop p {
    font-size: 20px;
    margin-bottom: 27px;
    color: #5C5C5C;
  }

  .thank-you-pop h3.cupon-pop {
    font-size: 25px;
    margin-bottom: 40px;
    color: #222;
    display: inline-block;
    text-align: center;
    padding: 10px 20px;
    border: 2px dashed #222;
    clear: both;
    font-weight: normal;
  }

  .thank-you-pop h3.cupon-pop span {
    color: #03A9F4;
  }

  .thank-you-pop a {
    display: inline-block;
    margin: 0 auto;
    padding: 9px 20px;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
    background-color: #8BC34A;
    border-radius: 17px;
  }

  .thank-you-pop a i {
    margin-right: 5px;
    color: #fff;
  }

  #ignismyModal .modal-header {
    border: 0px;
  }

  .edit_scheduler_btn {
    display: none;
  }

  .ajax-loader {
    display: block;
    position: fixed;
    z-index: 100;
    top: 50%;
    right: 50%;
    /* or: left: 50%; */
    margin-top: -50px;
    /* have of the elements height */
    margin-right: -50px;
    /* have of the elements widht */

    /* background-color: #000; */
  }
</style>

@endsection


@section("content")

<div class="container-fluid main_section">
  <div class="ajax-loader text-center" id="loader" style="display:none">
    <img src="{{ url('/assets/images/loading_icon.gif') }}" width="100">
    <br>
    <h3 style="color: red;">Loading articles...</h3>
  </div>
    <div class="row">
      @if(isset($is_publisher_article))
        <div class="col-sm-6">          
          <h4>
            <img width="80" src="{{ $publisher->publisher_image_path }}">
            Articles By: <b>{{ $publisher->publisher_title }}</b></h4>
          <hr>
        </div>
      @endif
        <div class="col-sm-offset-9">
          <a href="{{ url('/create_articles') }}" class="btn btn-info create_article_btn">Create New Article&nbsp;<i class="fa fa-plus"></i></a>
          <a href="{{ url('/goToArticleReports') }}" class='btn btn-danger'>Article cover reports</a>          
        </div>
    </div>
  <div class="row ">
    <div class="col-sm-3">
      <form id="searchArticleForm">
        <label for="">Search Article:</label>
        <div class="input-group">
          <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Search for an article">
          <div class="input-group-btn">
            <button id="myInputBtn" class="btn btn-warning" type="submit">
              <i class='fa fa-search'></i>
            </button>
          </div>
        </div>
      </form>
    </div>

    <div class="col-sm-offset-1 col-sm-4">
    </div>
  </div>


  <!-- ==========New logic begins -->
  <table class="table">
    <thead>
      <tr class="filters">
        <th>Filter by Author

          <select class="form-control" id="author-filter-table" class="select-table-filter" data-table="order-table">
            @if(isset($state) && $flag=="user")
            <option value="{{$state}}">{{$state}}</option>
            @elseif(isset($state) && $flag=="user" || isset($author_name))
            <option value="{{$state}}">{{$author_name}}</option>
            @else
            <option value="%" selected>None</option>
            @endif
            @if(isset($users))
            @foreach($users as $user)
            <option value="{{$user->name}}">{{$user->name}}</option>
            @endforeach
            @endif
          </select>



        </th>
        <th>Filter by Status
          <select class="form-control" id="status-filter-table" class="select-table-filter">
            @if(isset($state) && $flag=="status")
            <option value="{{$state}}">{{$state}}</option>
            @else
            <option value="%" selected>Any</option>
            @endif

            @if(isset($article_statuses))
            @foreach($article_statuses as $article_status)
            <option value="{{$article_status->status}}">{{$article_status->status}}</option>
            @endforeach
            @endif
          </select>

        </th>
        <th>Filter by Category
          <select class="form-control" id="category-filter-table" class="select-table-filter">
            @if(isset($state) && $flag=="category")
            <option value="{{$state}}">{{$state}}</option>
            @else
            <option value="%" selected> None</option>
            @endif

            @if(isset($categories))
            @foreach($categories as $category)
            <option value="{{$category->category_title}}">{{$category->category_title}}</option>
            @endforeach
            @endif
          </select>

        </th>
        <th>Filter by Priority
          <select class="form-control" id="priority-filter-table" class="select-table-filter">
            @if(isset($state) && $flag=="priority")
            <option value="{{$state}}">{{$state}}</option>
            @else
            <option value="%" selected>Any</option>
            @endif

            @if(isset($priorities))
            @foreach($priorities as $priority)
            <option value="{{$priority}}">{{$priority}}</option>
            @endforeach
            @endif
          </select>
        </th>
      </tr>
    </thead>
  </table>

  <div class="col-sm-2" style="background-color: #ddd; padding: 1%; border-bottom-left-radius: 25px;border-top-left-radius: 25px;">

    <form id="searchArticleFormByDates" autocomplete="off">
      <label>Filter by Date:</label>
      <div class="form-group">
        <input class="form-control" type="text" id="post_at" placeholder="Start Date here..." />
        <input class="form-control" type="hidden" id="start_date" value="{{$start_date}}" />

      </div>
  </div>

  <div class="col-sm-2" style="background-color: #ddd; padding: 1%;">
    <label>&nbsp;</label>
    <div class="form-group">
      <input class="form-control" type="text" id="post_at_to_date" placeholder="End Date here..." />
      <input class="form-control" type="hidden" id="end_date" value="{{$end_date}}" />
    </div>
  </div>
  <div class="col-sm-1" style="background-color: #ddd; padding: 1%; border-bottom-right-radius: 25px;border-top-right-radius: 25px;">
    <label>&nbsp;</label>
    <div class="form-group">
      <button class="btn btn-primary" type="submit">Search</button>
    </div>
  </div>
  </form>

</div>
</div>
<div class="row">
  @if (session()->has('message'))
  <div class="alert alert-info">
    {{ session('message') }}
  </div>
  @endif

</div>
</div>
<div class="container-fluid main_section">
  <div class="row">
    <div class="alert alert-info delete_article_success_msg">
      <span>Article Deleted Successfully!</span>
    </div>
    <!-- <div class="alert alert-success success_msg">
      <span>Weekend article scheduled Successfully!</span>
    </div> -->

    <div class="alert alert-danger datetime_required_error">
      <span>Datetime field is required</span>
    </div>
    <!-- 
    <div class="alert alert-warning already_exists_error">
      <span>This article is already scheduled for weekend!</span>
    </div> -->
  </div>

  <div class="row">
    <div class="table-responsive">
      <table id="article_table" class="table table-hover my-table" class="table table-striped dataTable dashbopard_panel" class="order-table" style="width:100%">
        <thead>
          <tr>
	    <th>Article ID</th>
            <th>Article Image</th>
            <th>Category</th>
            <th style="width: 33%;"><i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;Articles</th>
            <th><i class="fa fa-user"></i>&nbsp;Author</th>
            <th><i class="fa fa-clock-o"></i>&nbsp;Last Updated</th>
            <th>Status</th>
            <!-- <th>Priority</th> -->
            <th><i class='fa fa-clock-o'></i>&nbsp;Scheduler</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="myTable">
          @include('articles.filer_table')
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="ajax-load text-center" style="display:none">
  <p><img src="{{ url('/assets/imgs/loading_icon.gif') }}" height="100">Loading articles...</p>
</div>



<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-danger"><i class="fa fa-exclamation-triangle"></i>&nbsp;Delete Article</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure, you want to delete this Article?</p>
      </div>
      <div class="modal-footer">
        <button id="" role="button" class="btn article_delete_btn" data-dismiss="modal"><i class="fa fa-trash"></i></button>
      </div>
    </div>

  </div>
</div>

<!-- ====Success modal on article schedule begins========== -->

<div class="modal fade" id="article_schedule_modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
      </div>

      <div class="modal-body">

        <div class="thank-you-pop">
          <img src="http://goactionstations.co.uk/wp-content/uploads/2017/03/Green-Round-Tick.png" width="100" alt="">
          <h1>Thank You!</h1>
          <p>Your article is scheduled successfully!</p>
          <h3 class="cupon-pop">Publish Time: <span id="publish_time"></span></h3>

        </div>

      </div>

    </div>
  </div>
</div>

<!-- ====Success modal on article schedule ends========== -->


<!-- ====Datetime required modal on article schedule begins========== -->

<div class="modal fade" id="datetime_required_modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
      </div>

      <div class="modal-body">

        <div class="thank-you-pop">
          <img src="https://images.vexels.com/media/users/3/153978/isolated/preview/483ef8b10a46e28d02293a31570c8c56-warning-sign-colored-stroke-icon-by-vexels.png" width="100" alt="">
          <h1>Warning!</h1>
          <p>Please choose date & time before reschedule.</p>

        </div>

      </div>

    </div>
  </div>
</div>

<!-- ====Datetime required modal on article schedule ends========== -->

<!-- ====Success modal on article schedule begins========== -->

<div class="modal fade" id="article_already_schedule_modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
      </div>

      <div class="modal-body">

        <div class="thank-you-pop">
          <img src="http://goactionstations.co.uk/wp-content/uploads/2017/03/Green-Round-Tick.png" width="100" alt="">
          <h1>Thank You!</h1>
          <p>Your article is <b>Rescheduled</b> successfully!</p>
          <!-- <h3 class="cupon-pop">Publish Time: <span id="publish_time"></span></h3>							 -->
        </div>
      </div>

    </div>
  </div>
</div>

<!-- ====Success modal on article schedule ends========== -->


<!-- ====Article Deleted modal on article schedule begins========== -->

<div class="modal fade" id="delete_article_modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
      </div>

      <div class="modal-body">

        <div class="thank-you-pop">
          <img src="https://img.icons8.com/cute-clipart/64/000000/ok.png" width="100">
          <h1>Success!</h1>
          <p class="text-success">Your article deleted successfully!</p>
          <!-- <h3 class="cupon-pop">Publish Time: <span id="publish_time"></span></h3> -->
        </div>

      </div>

    </div>
  </div>
</div>

<!-- ====Article deleted on article schedule ends========== -->


<!-- ============ Weedend Scheduler Starts ============== -->

<div id="weekend_scheduler" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-success"><i class="fa fa-exclamation-triangle"></i>&nbsp;Schedule Article</h4>
      </div>
      <div class="modal-body">
        <p>Schedulable Time Slots</p>
        <i class="fa fa-info-circle"></i>&nbsp;You can schedule among following slots by clicking on it.
      </div>
      <div class="modal-footer"></div>
    </div>

  </div>
</div>

<!-- ============ Weedend Scheduler Ends ============== -->



<script type="text/javascript">
  var app_url = "{{ url('/') }}"
</script>
<script src="{{ asset('assets/js/all_articles_index.js') }}"></script>
<!-- <script src="{{ asset('js/app.js') }}"></script> -->
<!-- <script src="{{ asset('js/app_service_worker/service-worker.js') }}"></script>
<script src="{{ asset('js/app_service_worker/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>  -->
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script> -->
<!-- <script src="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"></script> -->
<script type='text/javascript' src="{{ url('/assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript">
    $(function () {
        $('.date-format').datetimepicker({
        });
    });
</script>





<script type="text/javascript">
  function deleteArticle(id) {
    article_id = id
    href_url = app_url + "/delete_articles/" + article_id
    $("#myModal .article_delete_btn").attr("id", article_id)

    $(".article_delete_btn").on("click", function(e) {
      e.preventDefault();
      $.ajax({
        url: href_url,
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        method: 'GET',
        beforeSend: function() {
          $('#loading_icon').show();
        },
        success: function(obj) {
          console.log("success");
          console.log(obj)
          if (obj.status == 'Article deleted successfully!') {
            // $(".delete_article_success_msg").show();
            $("#delete_article_modal").modal()
            $("#article_table tr#" + article_id).fadeOut()
          }
        },
        error: function(obj) {},
        complete: function() {}
      })

    })

  }


  function changeArticleStatus(article_id, article_status) {
    if (article_status == "Published") {
      $(".article" + article_id).removeClass("btn btn-info btn-edited btn-warning btn-danger btn-primary btn-republished")
      $(".article" + article_id).addClass("btn btn-success")
      button_class = "btn btn-success"

      $(".article_id" + article_id).attr("disabled", "disabled");
      $(".article_id" + article_id).css("pointer-events", "none");
      $(".pub_date_time" + article_id).show();
    }


    if (article_status == "Republished") {
      $(".article" + article_id).removeClass("btn btn-info btn-warning btn-danger btn-primary btn-edited")
      $(".article" + article_id).addClass("btn btn-republished")
      button_class = "btn btn-republished"

      $(".article_id" + article_id).attr("disabled", "disabled");
      $(".article_id" + article_id).css("pointer-events", "none");
    }

    if (article_status == "In Progress") {
      $(".article" + article_id).removeClass("btn btn-success btn-edited btn-warning btn-danger btn-primary btn-republished")
      $(".article" + article_id).addClass("btn btn-info")
      button_class = "btn btn-info"
      $(".article_id" + article_id).removeAttr("disabled");
      $(".article_id" + article_id).css("pointer-events", "visible");
      $(".pub_date_time" + article_id).show();
    }
    if (article_status == "Rejected") {
      $(".article" + article_id).removeClass("btn btn-success btn-info btn-edited btn-warning btn-primary btn-republished")
      $(".article" + article_id).addClass("btn btn-danger")
      button_class = "btn btn-danger"
      $(".article_id" + article_id).removeAttr("disabled");
      $(".article_id" + article_id).css("pointer-events", "auto");
      $(".pub_date_time" + article_id).show();
    }
    if (article_status == "Rollback") {
      $(".article" + article_id).removeClass("btn btn-info btn-success btn-edited btn-warning btn-danger btn-republished")
      $(".article" + article_id).addClass("btn btn-primary")
      button_class = "btn btn-primary"
      $(".article_id" + article_id).removeAttr("disabled");
      $(".article_id" + article_id).css("pointer-events", "auto");
      $(".pub_date_time" + article_id).hide();
    }
    if (article_status == "Needs Review") {
      $(".article" + article_id).removeClass("btn btn-info btn-success btn-edited btn-danger btn-primary btn-republished")
      $(".article" + article_id).addClass("btn btn-warning")
      button_class = "btn btn-warning"
      $(".article_id" + article_id).removeAttr("disabled");
      $(".article_id" + article_id).css("pointer-events", "auto");
      $(".pub_date_time" + article_id).show();

    }

    if (article_status == "Weekend") {
      $(".article" + article_id).removeClass("btn btn-primary btn-info btn-edited btn-warning btn-danger btn-republished")
      $(".article" + article_id).addClass("btn btn-default")
      button_class = "btn btn-default"
      $(".article_id" + article_id).removeAttr("disabled");
      $(".article_id" + article_id).css("pointer-events", "auto");
      $(".pub_date_time" + article_id).show();

    }

    if (article_status == "Edited") {
      $(".article" + article_id).removeClass("btn btn-primary btn-default btn-info btn-warning btn-danger btn-success btn-republished")
      $(".article" + article_id).addClass("btn btn-edited")
      button_class = "btn btn-edited"
      $(".article_id" + article_id).removeAttr("disabled");
      $(".article_id" + article_id).css("pointer-events", "auto");
      $(".pub_date_time" + article_id).show();

    }

    url = "{{url('/change_article_status')}}/" + article_status + "/" + article_id + "/" + button_class + ""
    console.log(url)
    $.ajax({
      url: url,
      headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
      },
      method: 'GET',
      beforeSend: function() {
        $('#loading_icon').show();
      },
      success: function(obj) {
        console.log("success");
      },
      error: function(obj) {},
      complete: function() {}
    })
  }


  function changeArticlePriority(article_id, article_priority) {

    if (article_priority == "Needs Coverage") {
      $(".article_priority" + article_id).removeClass("btn btn-success btn-warning btn-danger btn-primary")
      $(".article_priority" + article_id).addClass("btn btn-warning")
      button_class = "btn btn-warning"
    }
    if (article_priority == "Urgent") {
      $(".article_priority" + article_id).removeClass("btn btn-success btn-info btn-warning btn-primary")
      $(".article_priority" + article_id).addClass("btn btn-danger")
      button_class = "btn btn-danger"
    }
    if (article_priority == "--Select--") {
      $(".article_priority" + article_id).removeClass("btn btn-success btn-info btn-danger btn-warning btn-primary")
      $(".article_priority" + article_id).addClass("btn btn-default")
      button_class = "btn btn-default"
    }

    url = "{{url('/change_article_priority')}}/" + article_priority + "/" + article_id + "/" + button_class + ""
    console.log(url)
    $.ajax({
      url: url,
      headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
      },
      method: 'GET',
      beforeSend: function() {
        $('#loading_icon').show();
      },
      success: function(obj) {
        console.log("success");
      },
      error: function(obj) {},
      complete: function() {}
    })
  }
</script>
<script>
  $(function() {


    $(".success_msg, .datetime_required_error, .already_exists_error").hide()

  $(document).on("click", ".schedule_btn", function(e) {
    // $('.schedule_btn').on('click', function() {
      article_id = $(this)[0].id
      selector = '.datetime' + article_id

      datetime = $(selector).val()
      console.log(selector)
      if (datetime == '' || datetime == null) {

        $("#datetime_required_modal").modal()

      } else {
        // alert(datetime)
        url = 'schedule_weekend_article'
        console.log(datetime)
        console.log(url)
        $.ajax({
          url: url,
          headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          data: {
            'datetime': datetime,
            'article_id': article_id
          },
          method: 'POST',
          beforeSend: function() {
            $('#loading_icon').show();
          },
          success: function(obj) {
            console.log("success");
            if (obj.status == 'success') {
              // $(".success_msg").show()
              // $(".already_exists_error").hide()
              $("#article_schedule_modal").modal()
              $("#publish_time").html(datetime)
              $("#schedule_section" + article_id + "input").val(datetime)
              // $("#schedule_section"+article_id+" button.schedule_btn").replaceWith("<button class='btn btn-info scheduled_btn'>Scheduled</button>")                            
              // $("#schedule_section"+article_id+" button.edit_scheduler_btn").css('display', 'inline-block')
              // $("#schedule_section"+article_id+" input").attr('readonly', 'readonly')
            }

            if (obj.status == 'Article rescheduled') {
              $("#article_already_schedule_modal").modal()
              console.log("yaha")
              console.log(datetime)
              console.log("waha")
              $(".pub_date_time" + article_id).html(datetime)
              // $("#publish_time").html(datetime)
            }
          },
          error: function(obj) {},
          complete: function() {}
        })


      }
    });

    $(".edit_scheduler_btn").on("click", function() {
      $(".scheduled_btn").replaceWith("<button class='btn btn-primary schedule_btn'>Reschedule</button>")
      $(".date-format").removeAttr("readonly")
    })
  });
</script>

<script>

    $(document).on("focus", "input[name='schedule_time']", function(e) {
      $(this).datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true,
        changeMonth: true,
        changeYear: true,
      })
      .change(dateChanged)
      .on('changeDate', dateChanged);
      });
    
  function dateChanged(ev) {
    $(this).datepicker('hide');
    // alert($(this).val());
    var dateID = $(this).attr('class').split(" ").pop();
    var date = $(this).val();
    if (date === "") {
      $("#datetime_required_modal").modal("show");
    }
  else {
    $.ajax({
        url: "/get_weekend_schedule/" + date,
        type: "get",
        headers:{
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(response) {
          $("#weekend_scheduler").modal("show");
          $("#weekend_scheduler .modal-body").html("<p>Scheduling Time Slots</p>");
          for (time in response["times"]) {
            $("#weekend_scheduler .modal-body").append("\
              <div class='col-md-2'>\
                <a href='JavaScript:void(0)' dateID='" + dateID + "' class='btn schedule_time' style='background-color: " + response["times"][time] + "; color: white;'>" + time +"</a><br><br>\
              </div>\
              ");            
          }
        },
        error: function(obj) {
          alert("error");
        }
    });
}

  }

  $(document).on("click", ".schedule_time", function(e) {
    $(this).css("background-color", "red");
    $("." + $(this).attr('dateID')).val($("." + $(this).attr('dateID')).val() + " " + $(this).text());
    $("#weekend_scheduler").modal("toggle");
  });

</script>


@endsection

@if(isset($objects))
  <span>Welcome to Turori Tanda.</span>
@endif

