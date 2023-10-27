  $(function() {


    $(".article_delete_modal_btn").click(function() {
      article_id = $(this)[0].id
      href_url = app_url+'/delete_articles/'+article_id;
      $("#myModal #delete_modal").attr("href", href_url)
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
      if (article_status=="Edited") {
        $(this).removeClass("btn btn-primary btn-default btn-info btn-warning btn-danger btn-success")
        $(this).addClass("btn btn-edited")
        button_class ="btn btn-edited"
        $(".article_id"+article_id).removeAttr("disabled");
        $(".article_id"+article_id).css("pointer-events","auto");
      }
      
      url = app_ur+"/change_article_priority/"+article_priority+"/"+article_id+"/"+button_class+""
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
      

      url = app_url+"/change_article_priority/"+article_priority+"/"+article_id+"/"+button_class+""
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


  })

	var page = 1;
	$(window).scroll(function() {
	    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
	        page++;
	        loadMoreData(page);
	    }
	});


	function loadMoreData(page){
	  $.ajax(
      {
          url: '?page=' + page,
          type: "get",
          beforeSend: function()
          {
              $('.ajax-load').show();
          }
      })
      .done(function(data)
      {
          if(data.html == " "){
              $('.ajax-load').html("No more records found");
              return;
          }
          $('.ajax-load').hide();
          $("#post-data").append(data.html);
      })
      .fail(function(jqXHR, ajaxOptions, thrownError)
      {
            alert('server not responding...');
    });
}
  