@extends("layouts.app")

@section('title', 'My Dashboard')

@section('my_dashboard')
<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css"> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css">
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<style>
  #report-date-filter {
    max-width: 240px !important;
  }

  .dataTables_length {
    margin-left: 14px;
    margin-top: 5px;
  }

  .btn-edited {
    color: #fff;
    background-color: #5cb85c;
    border-color: #4cae4c;
  }

  .dark_mode {
    background-color: #000;
    color: #fff;
    transition: ease-in;
  }

  .all_change_white {
    color: #fff;
  }

  #nav-color-change {
    background-color: #337AB7;
    border: none;
    padding-bottom: 28px;
    /* width: 1850px; */
  }

  #button-color-change {
    background-color: #E8582B;
    border: none;
  }

  .pagination li {
    cursor: pointer;
  }

  .main_section {
    width: 1373px;
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

  .ajax-loader {
    display: block;
    position: fixed;
    z-index: 1031;
    top: 50%;
    right: 50%;
    /* or: left: 50%; */
    margin-top: -50px;
    /* have of the elements height */
    margin-right: -50px;
    /* have of the elements widht */
  }
</style>

@endsection


@section("content")

<div class="container main_section">
  <div class="ajax-loader text-center" id="loader" style="display:none">
    <img src="{{ url('/assets/images/loading_icon.gif') }}" width="100">
    <br>
    <h3 style="color:red;">Loading articles...</h3>
  </div>
  <div class="row">
    <h3><u>My Dashboard:</u></h3>
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

    <div class="col-sm-2">
      <div class="form-group">
        <label>Filter by Priority:</label>
        <select class="form-control" id="priority-filter-table">
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
      </div>
    </div>

    <div class="col-sm-offset-2 col-sm-5">
      <a href="{{ url('/create_articles') }}" class="btn btn-info create_article_btn">Create New Article&nbsp;<i class="fa fa-plus"></i></a>
      <a href="{{ url('/downloadExcel') }}" class="btn btn-primary">Download Excel&nbsp;<i class="fa fa-file-excel-o"></i></a>
      <a href="{{ url('/export_categories_pdf') }}" class="btn btn-success">Download PDF&nbsp;<i class="fa fa-file-pdf-o"></i></a>

      <!-- <label class="checkbox-inline"><input type="checkbox" id="dark_mode_btn" value="">Switch to Dark Mode</label> -->
      <!-- <button class="btn btn-info" id="enable-notifications" onclick="enableNotifications()"> Enable Push Notifications </button> -->

    </div>
  </div>



  <div class="row">

    <div class="col-sm-2">
      <div class="form-group">
        <label>Filter by Category:</label>
        <select class="form-control" id="category-filter-table">
          @if(isset($state) && $flag=="category")
          <option value="{{$state}}">{{$state}}</option>
          @else
          <option value="%" selected>None</option>
          @endif

          @if(isset($categories))
          @foreach($categories as $category)
          <option value="{{$category->category_title}}">{{$category->category_title}}</option>
          @endforeach
          @endif
        </select>
      </div>
    </div>

    <div class="col-sm-2">
      <div class="form-group">
        <label>Filter by Status:</label>
        <select class="form-control" id="status-filter-table">
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
      </div>
    </div>

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

  <div class="row">
    @if (session()->has('message'))
    <div class="alert alert-info">
      {{ session('message') }}
    </div>
    @endif
  </div>
</div>


<div class="container main_section">
  <div class="row">
    <div class="alert alert-info delete_article_success_msg">
      <span>Article Deleted Successfully!</span>
    </div>
  </div>

  <div class="row">
    <div class="table-responsive">
      <table id="article_table" class="table dataTable dashbopard_panel">
        <thead>
          <tr>
            <th>Article Image</th>
            <th>Category</th>
            <th style="width: 33%;"><i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;Articles</th>
            <th><i class="fa fa-clock-o"></i>&nbsp;Last Updated</th>
            <th>Status</th>
            <!-- <th>Priority</th> -->
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="myTable">
          @include('articles.my_dashboard_filter_table')
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

<script>
  var app_url = "{{ url("/") }}"
</script>
<script src="{{ asset('assets/js/my_dashboard.js') }}"></script>
<!-- <script src="{{ asset('js/app.js') }}"></script> -->
<!-- <script src="{{ asset('js/app_service_worker/service-worker.js') }}"></script>
<script src="{{ asset('js/app_service_worker/app.js') }}"></script> -->
<script>
  console.log()
</script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
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
            $(".delete_article_success_msg").show();
            $("#article_table tr#" + article_id).fadeOut()
          }
        },
        error: function(obj) {},
        complete: function() {}
      })

    })

  }



  // ======Change article status beings=======

  function changeArticleStatus(id, article_status) {
    article_id = id
    // alert(".article"+article_id)
    // console.log(article_status)
    if (article_status == "Published") {
      $(".article" + article_id).removeClass("btn btn-info btn-warning btn-danger btn-primary btn-edited")
      $(".article" + article_id).addClass("btn btn-success")
      button_class = "btn btn-success"

      $(".article_id" + article_id).attr("disabled", "disabled");
      $(".article_id" + article_id).css("pointer-events", "none");
    }
    if (article_status == "In Progress") {
      $(".article" + article_id).removeClass("btn btn-success btn-warning btn-danger btn-primary btn-edited")
      $(".article" + article_id).addClass("btn btn-info")
      button_class = "btn btn-info"
      $(".article_id" + article_id).removeAttr("disabled");
      $(".article_id" + article_id).css("pointer-events", "auto");
    }
    if (article_status == "Rejected") {
      $(".article" + article_id).removeClass("btn btn-success btn-info btn-warning btn-primary btn-edited")
      $(".article" + article_id).addClass("btn btn-danger")
      button_class = "btn btn-danger"
      $(".article_id" + article_id).removeAttr("disabled");
      $(".article_id" + article_id).css("pointer-events", "auto");
    }
    if (article_status == "Rollback") {
      $(".article" + article_id).removeClass("btn btn-info btn-success btn-warning btn-danger btn-edited")
      $(".article" + article_id).addClass("btn btn-primary")
      button_class = "btn btn-primary"
      $(".article_id" + article_id).removeAttr("disabled");
      $(".article_id" + article_id).css("pointer-events", "auto");
    }
    if (article_status == "Needs Review") {
      $(".article" + article_id).removeClass("btn btn-info btn-success btn-danger btn-primary btn-edited")
      $(".article" + article_id).addClass("btn btn-warning")
      button_class = "btn btn-warning"
      $(".article_id" + article_id).removeAttr("disabled");
      $(".article_id" + article_id).css("pointer-events", "auto");
    }

    if (article_status == "Weekend") {
      $(".article" + article_id).removeClass("btn btn-primary btn-success btn-info btn-warning btn-danger btn-edited")
      $(".article" + article_id).addClass("btn btn-default")
      button_class = "btn btn-default"
      $(".article_id" + article_id).removeAttr("disabled");
      $(".article_id" + article_id).css("pointer-events", "auto");
    }

    if (article_status == "Edited") {
      $(".article" + article_id).removeClass("btn btn-primary btn-default btn-info btn-warning btn-danger btn-success")
      $(".article" + article_id).addClass("btn btn-edited")
      button_class = "btn btn-edited"
      $(".article_id" + article_id).removeAttr("disabled");
      $(".article_id" + article_id).css("pointer-events", "auto");
    }

    url = app_url + "/change_article_status/" + article_status + "/" + article_id + "/" + button_class + ""
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

  // ======Change article status ends=======


  // ======Change article priority begins=======

  function changeArticlePriority(id, article_priority) {

    article_id = id;
    if (article_priority == "Needs Coverage") {
      $(".article_priority" + article_id).removeClass("btn btn-default btn-danger")
      $(".article_priority" + article_id).addClass("btn btn-warning")
      button_class = "btn btn-warning"
    }
    if (article_priority == "Urgent") {
      $(".article_priority" + article_id).removeClass("btn btn-warning btn-default")
      $(".article_priority" + article_id).addClass("btn btn-danger")
      button_class = "btn btn-danger"
    }
    if (article_priority == "--Select--") {
      $(".article_priority" + article_id).removeClass("btn btn-warning btn-danger")
      $(".article_priority" + article_id).addClass("btn btn-default")
      button_class = "btn btn-default"
    }

    url = app_url + "/change_article_priority/" + article_priority + "/" + article_id + "/" + button_class + ""
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

  // ======Change article priority ends=======
</script>

@endsection