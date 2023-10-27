@extends("layouts.app")
@section('title', 'Republishable Articles')
@section("published_article_internal_css")

<style type="text/css">

  .pagination li {
    cursor: pointer;
  }
  .main_section {
    /*width: 1373px;*/
  }
  #article_table .btn-primary {
    background-color: #FF7F50 !important;
    border-color: #FF7F50 !important;
  }

  #loading_icon {
    width:100%;
    height:100%;
    position:fixed;
    z-index:9999;
    /*background:url("https://www.creditmutuel.fr/cmne/fr/banques/webservices/nswr/images/loading.gif") no-repeat center center rgba(0,0,0,0.25)*/
    background:url("{{ url('/assets/images/loading_icon.gif')  }}") no-repeat center center rgba(0,0,0,0.25);
    background-size: 100px;
    display: none;
  }
  
    #nav-color-change  {
      background-color: #337AB7;
      border:none;
      padding-bottom: 30px;
      /*margin-right: -1000px;  */
      /*width: 1480px;*/


    }
    #button-color-change{
      background-color:#E8582B;
      border:none;
    }
  
  .btn-edited, .btn-edited:hover, .btn-edited:focus {
    color: #fff;
    background-color: #337AB7;
  }


  .btn-republished, .btn-republished:hover, .btn-republished:focus {
    color: #fff;
    background-color: #286090;
  }

  
  .notification_msg {
    display: none;
  }

</style>
<style>
/* The container */
.container_checkbox {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container_checkbox input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container_checkbox:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container_checkbox input:checked ~ .checkmark {
  background-color: #337AB7;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container_checkbox input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container_checkbox .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
</style>

@endsection

@section("content")

<div class="container main_section">
  <div class="row">
    <!-- <p>Welcome to Volv</p> -->
    <h3 class="text-primary"><b><u>Republishable Articles on Volv App:</u></b></h3>
  </div>
  <div class="row">
    <div class="notification_msg">
      <ul class="alert alert-success">
        <span><strong>Push notification sent!</strong></span>
      </ul>
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
    <div class="table-responsive">
      <table id="article_table" class="table table-striped dataTable dashbopard_panel">
        <thead>
          <tr>
            <th>Article Image</th>
            <th>Category</th>
            <th style="width: 33%;"><i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;Articles</th>
            <th><i class="fa fa-user"></i>&nbsp;Author</th>
            <th><i class="fa fa-clock-o"></i>&nbsp;Last Updated</th>
            <!-- <th>Status</th> -->
            <th style="width: 200px;">Notification Text</th>
            <th>Breaking News</th>
            <th>Status</th>
            <th>Action</th>
            <th>Activity</th>
          </tr>
        </thead>
        <tbody id="post-data">
          @include("articles.data")
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


<!-- ===============Confirm notification begins -->

  <!-- Modal -->
  <div id="notification_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-bell"></i>&nbsp;Confirm Notification</h4>
        </div>
        <div class="modal-body">
          <p><strong class="text-info">Are you sure you want to send this as notification?</strong></p>

          <table class="table table-bordered table-hover table-striped" style="font-size: 12px;">
            <thead>
              <tr>
                <th>Article Image</th>
                <th style="width: 40%;">Notification Text</th>
                <th>Article Heading</th>
                <th>Article Summary</th>
              </tr>
            </thead>
            <tbody>
              <tr>

              </tr>
            </tbody>
          </table>
          

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-info send_notification_btn">Notify</button>
        </div>
      </div>

    </div>
  </div>

<!-- ===============Confirm notification ends -->



<!-- ==========Notification sent successfully modal begins========== -->

<div class="modal fade" id="notification_sent_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
                     </div>
					
                    <div class="modal-body">
                       
						<div class="thank-you-pop">
							<img src="http://goactionstations.co.uk/wp-content/uploads/2017/03/Green-Round-Tick.png" width="100" alt="">
							<h1>Thank You!</h1>
							<p>Notification sent successfully!</p>

 						</div>
                         
                    </div>
					
                </div>
            </div>
        </div>


<!-- =========Notification sent successfully modal ends================ -->
    
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

  var app_url = "{{ url("/") }}"

function deleteArticle(id) {
      article_id = id
      href_url = app_url+"/delete_articles/"+article_id
      $("#myModal .article_delete_btn").attr("id", article_id)

      $(".article_delete_btn").on("click", function(e) {
          e.preventDefault();
          $.ajax({
            url: href_url,
            headers:{
               'X-CSRF-TOKEN': "{{ csrf_token() }}"
             },   
            method: 'GET',
            beforeSend: function() {
              $('#loading_icon').show();
            },
            success: function(obj) {
              console.log("success");
              console.log(obj)
              if (obj.status=='Article deleted successfully!') {
                $(".delete_article_success_msg").show();
                $("#article_table tr#"+article_id).fadeOut()
              }
            },
            error: function(obj) {
            },
            complete: function() {
            }
          })

      })

    }


    function sendNotification(id) {


      inputs = $(".notif_sequence")
      checkboxes = $(".notification_sequence")

      obj ={}
      for(var i = 0; i < checkboxes.length; i++){
        if($(checkboxes[i]).is(":checked")) {
          index  = String($($($(checkboxes[i])[0]).parent().siblings()[1]).val())
          // console.log(index)
          obj[index] = $(checkboxes[i]).val() 
        }
      }

      console.log("id")
      console.log(id)
      objArray=[];
      $.each(obj, function(key, val) {
        objArray.push(val)
      })
      
      articleStack = "("+objArray.join(",")+")";
      console.log("Pahle")
      console.log($('#notification_modal'))
      // if($('#notification_modal')) {
      //   $('#notification_modal').empty()
      // }
      $('#notification_modal').modal('show');

      // $("#notification_modal").modal('toggle')
      article_id = id
      $("#notification_modal .send_notification_btn").attr("id", article_id)

      // article_summary= article_summary.replace(/'/g, "\\'");
      // $("#notification_modal table tbody tr:first-child").replaceWith("<tr><td><img src="+"'"+article_image+"'"+" width='100'></td><td>"+notification_text+"</td><td>"+article_heading+"</td><td>"+article_summary+"</td></tr>")

      get_notification_data_url = app_url+"/get_notification_data/"+article_id
      $.ajax({
            url: get_notification_data_url,
            headers:{
               'X-CSRF-TOKEN': "{{ csrf_token() }}"
             },   
            method: 'GET',
            beforeSend: function() {
              $('#loading_icon').show();
            },
            success: function(obj) {

              console.log("con")
              console.log(obj)
              $("#notification_modal table tbody tr").empty()
              $.each(obj, function(key, val) {
                  $('#notification_modal table tbody tr').append("<td>"+val+"</td>")
              });

            },
            error: function(obj) {
              alert("Error!")
            },
            complete: function() {
            }
          })




      $(".send_notification_btn").on("click", function(e) {

        console.log(articleStack)
        console.log(articleStack=="()")

        if(articleStack=="()") {
          articleStack = "("+article_id+")"
          href_url = app_url+"/notify/"+article_id+"/"+articleStack
        }
        else {
          href_url = app_url+"/notify/"+article_id+"/"+articleStack          
        }

        console.log(articleStack)
        console.log(href_url)


        // if(articleStack=="()") {
        //   swal({
        //     title: "Wait!",
        //     text: "Please check articles before notify.",
        //     icon: "warning",
        //     button: "ok",
        //   });                    
        // }
        // else {

            e.preventDefault();
            $.ajax({
              url: href_url,
              headers:{
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
              },   
              method: 'GET',
              beforeSend: function() {
                $('#loading_icon').show();
              },
              success: function(obj) {
                $("#notification_warning_modal").modal('hide')
                $(".notification_msg").hide()
                if (obj.status=='success') {
                  alert("Notification sent successfully.")
                  $("#notification_sent_modal").modal()
                  // $(".notify_btn").replaceWith("<button class='btn btn-success'>Sent</button>");
                  $(".notification_sent_modal").show()
                  location.reload()
                }

                if (obj.status=='Notification already Sent!') {
                  alert("Notification already Sent!")
                  location.reload()
                }


                

                $('#notification_warning_modal').modal('hide');

              },
              error: function(obj) {
                $('#notification_warning_modal').modal('hide');
              },
              complete: function() {
              }
            })


        // }

      })

    }




    function changeArticleStatus(article_id, article_status) {

      if (article_status=="Published") {
        $(".article"+article_id).removeClass("btn btn-info btn-warning btn-danger btn-primary btn-edited btn-republished")
        $(".article"+article_id).addClass("btn btn-success")
        button_class ="btn btn-success"

        $(".article_id"+article_id).attr("disabled","disabled");
        $(".article_id"+article_id).css("pointer-events","none");
      }

      if (article_status=="Republished") {
        $(".article"+article_id).removeClass("btn btn-info btn-warning btn-danger btn-primary btn-edited")
        $(".article"+article_id).addClass("btn btn-republished")
        button_class ="btn btn-republished"

        $(".article_id"+article_id).attr("disabled","disabled");
        $(".article_id"+article_id).css("pointer-events","none");
      }



      if (article_status=="In Progress") {
        $(".article"+article_id).removeClass("btn btn-success btn-warning btn-danger btn-primary btn-edited btn-republished")
        $(".article"+article_id).addClass("btn btn-info")
        button_class ="btn btn-info"
        $(".article_id"+article_id).removeAttr("disabled");
        $(".article_id"+article_id).css("pointer-events","visible");

      }
      if (article_status=="Rejected") {
        $(".article"+article_id).removeClass("btn btn-success btn-info btn-warning btn-primary btn-edited btn-republished")
        $(".article"+article_id).addClass("btn btn-danger")
        button_class ="btn btn-danger"
        $(".article_id"+article_id).removeAttr("disabled");
        $(".article_id"+article_id).css("pointer-events","visible");
      }
      if (article_status=="Rollback") {
        $(".article"+article_id).removeClass("btn btn-info btn-success btn-warning btn-danger btn-edited btn-republished")
        $(".article"+article_id).addClass("btn btn-primary")
        button_class ="btn btn-primary"
        $(".article_id"+article_id).removeAttr("disabled");
        $(".article_id"+article_id).css("pointer-events","visible");

      }
      if (article_status=="Needs Review") {
        $(".article"+article_id).removeClass("btn btn-info btn-success btn-danger btn-primary btn-edited btn-republished")
        $(".article"+article_id).addClass("btn btn-warning")
        button_class ="btn btn-warning"
        $(".article_id"+article_id).removeAttr("disabled");
        $(".article_id"+article_id).css("pointer-events","visible");

      }

      if (article_status=="Pending") {
        $(".article"+article_id).removeClass("btn btn-primary btn-info btn-warning btn-danger btn-edited btn-republished")
        $(".article"+article_id).addClass("btn btn-default")
        button_class ="btn btn-default"
        $(".article_id"+article_id).removeAttr("disabled");
        $(".article_id"+article_id).css("pointer-events","visible");

      }
      if (article_status=="Edited") {
        $(".article"+article_id).removeClass("btn btn-primary btn-default btn-info btn-warning btn-danger btn-success btn-republished")
        $(".article"+article_id).addClass("btn btn-edited")
        button_class ="btn btn-edited"
        $(".article_id"+article_id).removeAttr("disabled");
        $(".article_id"+article_id).css("pointer-events","auto");
        $(".article_id"+article_id).css("pointer-events","visible");

      }
      url = app_url+"/change_article_status/"+article_status+"/"+article_id+"/"+button_class+""
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
    }

// =========Send notification logic begins  
      $('#loading_icon').hide();
      $(".notify_btn").on("click", function(e) {
        // alert("go ahead")
        
          article_id = $(this)[0].id
          notify_url = app_url+'/notify/'+article_id;
          // alert(notify_url)
          e.preventDefault();
          $.ajax({
            url: notify_url,
            headers:{
               'X-CSRF-TOKEN': "{{ csrf_token() }}"
             },   
            method: 'GET',
            beforeSend: function() {
              $('#loading_icon').show();
            },
            success: function(obj) {
              $("#notification_warning_modal").modal('hide')
              $(".notification_msg").hide()
              if (obj.status=='success') {
                alert("Notification sent successfully.")
                $("#notification_sent_modal").modal()
                // $(".notify_btn").replaceWith("<button class='btn btn-success'>Sent</button>");
                $(".notification_msg").show()
                location.reload()
              }
            },
            error: function(obj) {
              alert("error")
            },
            complete: function() {
              $('#loading_icon').hide();              
            }
          })
      })    
// =========Send notification logic ends 

</script>

<script type="text/javascript" src="{{ url('/assets/js/published_articles.js') }}"></script>

@endsection