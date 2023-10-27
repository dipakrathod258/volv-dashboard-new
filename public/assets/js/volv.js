// ======Change article status beings=======

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

    url = app_url+"/change_article_status/"+article_status+"/"+article_id+"/"+button_class+""
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

// ======Change article status ends=======


// ======Change article priority begins=======

  $("#article_table select.priority_filter_article").on("change", function() {
    article_id = $(this)[0].id;
    article_priority = $(this).val();
    if (article_priority=="Needs Coverage") {
      $(this).removeClass("btn btn-default btn-danger")
      $(this).addClass("btn btn-warning")
      button_class ="btn btn-warning"
    }
    if (article_priority=="Urgent") {
      $(this).removeClass("btn btn-warning btn-default")
      $(this).addClass("btn btn-danger")
      button_class ="btn btn-danger"
    }
    if (article_priority=="--Select--") {
      $(this).removeClass("btn btn-warning btn-danger")
      $(this).addClass("btn btn-default")
      button_class ="btn btn-default"
    }

    url = app_url+"/change_article_priority/"+article_priority+"/"+article_id+"/"+button_class+""
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
 
// ======Change article priority ends=======

// ======Filter articles by Date range begins=======

$("#search_btn" ).click(function() {
  var start_date = $("#post_at").val();
  var end_date = $("#post_at_to_date").val();
  date=[]
  date[0]= start_date
  date[1]= end_date
  url = app_url+"/filterArticleDateMyDashboard"        
  $.get(url , { date : date } , function(htmlCode){ //htmlCode is the code retured from your controller
    $("body").html(htmlCode);
    $("#post_at").val(start_date)
    $("#post_at_to_date").val(end_date)
    start_date = date[0]
    end_date = date[1]
  });
});
// ======Filter articles by Date range ends=======

//Change dark mode beings

  $("#dark_mode_btn").on("click", function() {
    $("body").toggleClass("dark_mode");
  })

//Change dark mode ends



// ======Article filters on dashboard begins=======

var  filters = {
    user: null,
    status: null,
    milestone: null,
    priority: null,
    tags: null
  };
  
  function updateFilters() {
    $('.task-list-row').hide().filter(function() {
    var self = $(this),
        result = true;        
    Object.keys(filters).forEach(function (filter) {
        if (filters[filter] && (filters[filter] != 'None') && (filters[filter] != 'Any')) {
        result = result && filters[filter] === self.data(filter);
        }
    });
    return result;
    }).show();
  }
  
  function changeFilter(filterName) {
    filters[filterName] = this.value;
    updateFilters();
  }
  
  $('#assigned-user-filter').on('change', function() {
  changeFilter.call(this, 'user');
  });
  
  $('#status-filter').on('change', function() {
  changeFilter.call(this, 'status');
  });
  
  $('#milestone-filter').on('change', function() {
  changeFilter.call(this, 'milestone');
  });
  
  $('#priority-filter').on('change', function() {
  changeFilter.call(this, 'priority');
  });
  
  $('#tags-filter').on('change', function() {
  changeFilter.call(this, 'tags');
  });
  
  // ======Article filters on dashboard ends=======
  
  
  
  // ====Search article using ajax loaded begins
  
  $("#myInputBtn").on("click", function(){
    // alert("ok")
    keyword = $("#keyword").val();
    // alert(keyword)
    url = '?page='+keyword+"&keyword="+keyword
  
    $.ajax(
          {
              url: url,
              type: "get",
              beforeSend: function()
              {
                  $('.ajax-load').show();
                  $('#loading_icon').show()
              }
          })
          .done(function(data)
          {
              if(data.html){
                $('.ajax-load').hide();
                $("#myTable").replaceWith("<tbody id='myTable'>"+data.html+"</tbody>");
              }
              else {
                $('.ajax-load').html("<div class='alert alert-danger'><b>No more articles found</b></div>");
                return;                
              }
          })
          .fail(function(jqXHR, ajaxOptions, thrownError)
          {
                alert('server not responding...');
          });
          // alert("welcome to volv!")
  });