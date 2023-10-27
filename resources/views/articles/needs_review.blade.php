@extends('layouts.app')
@section('title', 'Needs Review Articles')
@section('needs_review_internal_css')

<style type="text/css">
    #nav-color-change  {
      background-color: #337AB7;
      border:none;
      padding-bottom: 30px;
    }

    #button-color-change{
      background-color:#E8582B;
      border:none;
    }
</style>

@endsection

@section("content")

<div class="container main_section">
  <div class="row">
    <h3 class="text-warning"><b><u>Needs Review Articles on Volv App:</u></b></h3>
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
    <div class="table-responsive">
      <table id="article_table" class="table table-striped dataTable dashbopard_panel ">
        <thead>
          <tr>
            <th>Article Image</th>
            <th>Category</th>
            <th style="width: 33%;"><i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;Articles</th>
            <th><i class="fa fa-user"></i>&nbsp;Author</th>
            <th><i class="fa fa-clock-o"></i>&nbsp;Last Updated</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

          @foreach($articles as $article)
          <tr id="{{$article->id}}">
          <td>
            <img src="{{ $article->article_image }}" width="150">
          </td>
          <td>
            <span>{{ $article->article_category}}</span>
          </td>
          <td>
            <span><b>{{ $article->article_heading}}</b></span>
            <p style="margin-top: 15px; text-align: justify;">{{ $article->article_summary}}</p>
            <p style="color: #337ab7;"><span><b>Word count: <span class="text-success">{{ str_word_count($article->article_summary) }}</span></b></span>&nbsp;<span class="pull-right"><b>Character Count: <span class="text-success">{{ strlen($article->article_summary) }}</span></b></span></p>
          </td>
          <td>{{$article->article_author}}</td>
          <td>
          {{$article->time_ago}}
          <br>
          <br>
          @if(isset($article->time_stamp))
            {{ $article->time_stamp }}
          @endif
          </td>
          <td>
          <div class="form-group" style="width: 140px;">
          <select class="form-control {{$article->button_class}} article_status" id="{{$article->id}}">
            @foreach($article_statuses as $article_status)
                @if($article_status->status ==$article->article_status)
                <option value="{{$article_status->status}}" selected="selected">{{$article_status->status}}</option> 
                @elseif($article_status->status !=$article->article_status)
                <option value="{{$article_status->status}}">{{$article_status->status}}</option> 
                @endif
            @endforeach
          </select>
          </div> 
          </td>

          <td>
            <a href="{{ url('/view_articles') }}/{{$article->id}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
            <a href="{{ url('/edit_articles') }}/{{$article->id}}" class="btn btn-primary article_id{{$article->id}}" {{($article->article_status=="Published")? "style=pointer-events:none; disabled":""}}><i class="fa fa-edit"></i></a>
            <br>
           <a href="Dataset is the input function"></a>

            <a type="button" class="btn btn-danger article_delete_modal_btn" data-toggle="modal" data-target="#myModal"  id="{{$article->id}}"><i class="fa fa-trash" title="Delete"></i></a>

          </td>

          </tr>


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
          @endforeach
    </tbody>
      </table>      
    </div>
  </div>
</div>

 <script type="text/javascript">
  $(function() {

    $(".article_delete_modal_btn").click(function() {
      article_id = $(this)[0].id
      href_url = "{{url('/delete_articles')}}/"+article_id+"/"
      $("#myModal #delete_modal").attr("href", href_url)
    })

    $("#article_table select.article_status").on("change", function() { 
      article_id = $(this)[0].id;
      article_status = $(this).val();
      console.log(article_status)
      if (article_status=="Published") {
        $(this).removeClass("btn btn-info btn-warning btn-danger btn-primary btn-edited")
        $(this).addClass("btn btn-success")
        button_class ="btn btn-success"

        $(".article_id"+article_id).attr("disabled","disabled");
        $(".article_id"+article_id).css("pointer-events","none");
        $(".article_id"+article_id).css("pointer-events","auto");
      }
      if (article_status=="In Progress") {
        $(this).removeClass("btn btn-success btn-warning btn-danger btn-primary btn-edited")
        $(this).addClass("btn btn-info")
        button_class ="btn btn-info"
        $(".article_id"+article_id).removeAttr("disabled");
        $(".article_id"+article_id).css("pointer-events","auto");
      }
      if (article_status=="Rejected") {
        $(this).removeClass("btn btn-success btn-info btn-warning btn-primary btn-edited")
        $(this).addClass("btn btn-danger")
        button_class ="btn btn-danger"
        $(".article_id"+article_id).removeAttr("disabled");
        $(".article_id"+article_id).css("pointer-events","auto");
      }
      if (article_status=="Rollback") {
        $(this).removeClass("btn btn-info btn-success btn-warning btn-danger btn-edited")
        $(this).addClass("btn btn-primary")
        button_class ="btn btn-primary"
        $(".article_id"+article_id).removeAttr("disabled");
        $(".article_id"+article_id).css("pointer-events","auto");
      }
      if (article_status=="Needs Review") {
        $(this).removeClass("btn btn-info btn-success btn-danger btn-primary btn-edited")
        $(this).addClass("btn btn-warning")
        button_class ="btn btn-warning"
        $(".article_id"+article_id).removeAttr("disabled");
        $(".article_id"+article_id).css("pointer-events","auto");
      }

      if (article_status=="Pending") {
        $(this).removeClass("btn btn-primary btn-info btn-warning btn-danger btn-edited")
        $(this).addClass("btn btn-default")
        button_class ="btn btn-default"
        $(".article_id"+article_id).removeAttr("disabled");
        $(".article_id"+article_id).css("pointer-events","auto");
      }

      if (article_status=="Edited") {
        $(this).removeClass("btn btn-primary btn-default btn-info btn-warning btn-danger btn-success")
        $(this).addClass("btn btn-edited")
        button_class ="btn btn-edited"
        $(".article_id"+article_id).removeAttr("disabled");
        $(".article_id"+article_id).css("pointer-events","auto");
      }

      url = "{{url('/change_article_status')}}/"+article_status+"/"+article_id+"/"+button_class+""
      console.log(url)
      $.ajax({
        url: url,
        headers:{
           'X-CSRF-TOKEN': "{{ csrf_token() }}"
         },   
        method: 'GET',
        beforeSend: function() {
          $('#loading_icon').show();
        },
        success: function(obj) {
          console.log("success");
        },
        error: function(obj) {
        },
        complete: function() {
        }
      })
    })

    $("#article_table select.priority_filter_article").on("change", function() {   
      article_id = $(this)[0].id;
      article_priority = $(this).val();
      console.log(article_priority)
      if (article_priority=="Low") {
        $(this).removeClass("btn btn-info btn-warning btn-danger btn-primary")
        $(this).addClass("btn btn-warning")
        button_class ="btn btn-warning"
      }
      if (article_priority=="Medium") {
        $(this).removeClass("btn btn-success btn-warning btn-danger btn-primary")
        $(this).addClass("btn btn-info")
        button_class ="btn btn-info"
      }
      if (article_priority=="High") {
        $(this).removeClass("btn btn-info btn-success btn-danger btn-primary")
        $(this).addClass("btn btn-danger")
        button_class ="btn btn-danger"
      }

      url = "{{url('/change_article_priority')}}/"+article_priority+"/"+article_id+"/"+button_class+""
      console.log(url)
      $.ajax({
        url: url,
        headers:{
           'X-CSRF-TOKEN': "{{ csrf_token() }}"
         },   
        method: 'GET',
        beforeSend: function() {
          $('#loading_icon').show();
        },
        success: function(obj) {
          console.log("success");
        },
        error: function(obj) {
        },
        complete: function() {
        }
      })
    })
   
    $("#author_filter" ).change(function() {
        var state = $(this).val();

        $.get('{{ url("/filterArticleTable") }}' , { state : state } , function(htmlCode){ //htmlCode is the code retured from your controller
          console.log("htmlCode")
          console.log(state)
            $("body").html(htmlCode);
        });
      });

    $("#search_btn" ).click(function() {
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        date=[]
        date[0]= start_date
        date[1]= end_date

        $.get('{{ url("/filterArticleDate") }}' , { date : date } , function(htmlCode){ //htmlCode is the code retured from your controller
          console.log("htmlCode")
          console.log(state)
          start_date = state[0]
          console.log(start_date)
          console.log(end_date)
          end_date = state[1]
          $("#start_date").val(start_date)
          $("#end_date").val(end_date)
            $("body").html(htmlCode);

        });
      });



    $( "#category_filter" ).change(function() {
        var state = $(this).val();

        $.get('{{ url("/filterArticleTableByCategory") }}' , { state : state } , function(htmlCode){ //htmlCode is the code retured from your controller
          console.log("htmlCode")
          console.log(state)
            $("body").html(htmlCode);
        });
      });

    $( "#priority_filter" ).change(function() {
        //this is the #state dom element
        var state = $(this).val();
        console.log("ye hain value")
        console.log(state)
        $.get('{{ url("/filterArticleTableByPriority") }}' , { state : state } , function(htmlCode){ //htmlCode is the code retured from your controller
          console.log("htmlCode")
          console.log(state)
            $("body").html(htmlCode);
        });
      });

    $("#status_filter").change(function() {
        var state = $(this).val();
        $.get('{{ url("/filterArticleTableByStatus") }}' , { state : state } , function(htmlCode){ 
          console.log("htmlCode")
          console.log(state)
          $("body").html(htmlCode);
        });
      });

    $( "#search_btn" ).click(function() {
        //this is the #state dom element
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        state=[]
        state[0] = start_date
        state[1] = end_date

        console.log("start_date")
        console.log(start_date)
        console.log("end_date")
        console.log(end_date)
      });

    $("#article_table select.form-control --Select-- article_priority").on("change", function() {
      article_id = $(this)[0].id;
      article_priority = $(this).val();

      console.log(article_priority)
      if (article_status=="Low") {
        $(this).removeClass("btn btn-info btn-warning btn-danger btn-primary")
        $(this).addClass("btn btn-warning")
        button_class ="btn btn-warning"
      }
      if (article_status=="Medium") {
        $(this).removeClass("btn btn-success btn-warning btn-danger btn-primary")
        $(this).addClass("btn btn-primary")
        button_class ="btn btn-primary"
      }
      if (article_status=="High") {
        $(this).removeClass("btn btn-success btn-info btn-warning btn-primary")
        $(this).addClass("btn btn-danger")
        button_class ="btn btn-danger"
      }
      if (article_status=="--Select--") {
        $(this).removeClass("btn btn-success btn-info btn-danger btn-warning btn-primary")
        $(this).addClass("btn btn-default")
        button_class ="btn btn-default"
      }

      url = "{{url('/change_article_priority')}}/"+article_priority+"/"+article_id+"/"+button_class+""
      console.log(url)
      $.ajax({
        url: url,
        headers:{
           'X-CSRF-TOKEN': "{{ csrf_token() }}"
         },   
        method: 'GET',
        beforeSend: function() {
          $('#loading_icon').show();
        },
        success: function(obj) {
          console.log("success");
        },
        error: function(obj) {
        },
        complete: function() {
        }
      })


    })

      $('#start_date, #end_date').datepicker({dateFormat: 'yy-mm-dd'});
      @if(isset($start_date))
        $("#start_date").val('{{$start_date}}')
      $('#start_date, #end_date').datepicker({dateFormat: 'yy-mm-dd'});
      @endif
      @if(isset($end_date))
        $("#end_date").val('{{$end_date}}')
        $('#start_date, #end_date').datepicker({dateFormat: 'yy-mm-dd'});
      @endif
  })
</script>
@endsection