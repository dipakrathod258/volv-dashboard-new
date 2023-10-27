//Change dark mode beings
$("#dark_mode_btn").on("click", function () {
    $("body").toggleClass("dark_mode");
});

//Change dark mode ends


// ====Datepicker for filter by date begins

$('#post_at').datepicker({
    todayHighlight: true,
    format: 'yyyy-mm-dd',
    autoclose: true
});
$('#post_at_to_date').datepicker({
    todayHighlight: true,
    format: 'yyyy-mm-dd',
    autoclose: true
});

// ====Datepicker for filter by date ends

// ===Search article functinality begins 

$("#myInput").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});

// ===Search article functinality ends 



// function updateFilters() {
//   $('.task-list-row').hide().filter(function() {
//   var self = $(this),
//       result = true;        
//   Object.keys(filters).forEach(function (filter) {
//       if (filters[filter] && (filters[filter] != 'None') && (filters[filter] != 'Any')) {
//       result = result && filters[filter] === self.data(filter);
//       }
//   });
//   return result;
//   }).show();
// }

var page = 1;

// ====Search article using start date & end date ajax loaded begins ==============//

$("#searchArticleFormByDates").on('submit',function(e){
  e.preventDefault();
  page=1;
  priority = $("#priority-filter-table").val();
  status = $("#status-filter-table").val();
  category = $("#category-filter-table").val();
  start_date=$('#post_at').val();
  end_date=$('#post_at_to_date').val();
  // if (start_date=='' && end_date==''){
  //     start_date=$("#start_date").val();
  //     end_date=$("#end_date").val();
  // }
  url = '?page='+page+"&status="+status+"&category="+category+"&priority="+priority

  $.ajax({
      url: url,
      type: "get",
      beforeSend: function () {
          $('.ajax-load').show();
      },
      data:{
          start_date,
          end_date,
      },
      beforeSend:function(){
            $('html,body').css({"pointer-events":"none", "background":"#e9e9e9", "overflow": "hidden",'height': '100%'});
            $("#loader").show();
      },
      complete:function(){
            $('html,body').css({"pointer-events":"auto", "background-color":"","overflow":"auto",'height': 'auto'});
            $("#loader").hide();
      },
      success: function(response) {
            console.log("dates response",response)
            $('tbody tr').html('');
            if (response.html) {
                $("#myTable").append(response['html']);
            }
            else{
                $('.ajax-load').show()
                $('.ajax-load').html("<div class='alert alert-danger'><b>No articles found</b></div>");
                return;
            }
      },
      error: function(obj) {
         alert(obj)
      }
  });

});
// ====Search article using start date & end date ajax loaded ends  ==============//


// ======Article filters on dashboard begins=======
$("#priority-filter-table,#status-filter-table,#category-filter-table").on('change', function (e) {
    e.preventDefault();
    //Set previous selected date to null
    $("#post_at").val("");
    $("#post_at_to_date").val("");
    $("#post_at").datepicker('setDate', null);
    $("#post_at_to_date").datepicker('setDate', null);
    //set the date which are sent
    start_date=$("#start_date").val();
    end_date=$("#end_date").val();
    // console.log("see",start_date,end_date);

    page = 1;
    var priority = $('#priority-filter-table').children("option:selected").val();
    var status = $('#status-filter-table').children("option:selected").val();
    var category = $('#category-filter-table').children("option:selected").val();
    console.log("checking", priority, status, category);
    // url = '?page='+page+"&status="+status+"&category="+category+"&priority="+priority
   url="/"
    $.ajax({
      url: url,
      headers:{
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },   
      method: 'GET',
      data:{
        start_date,
        end_date
      },
      beforeSend:function(){
        $('html,body').css({"pointer-events":"none", "background":"#e9e9e9", "overflow": "hidden",'height': '100%'});
        $("#loader").show();
        
      },
      complete:function(){
        $('html,body').css({"pointer-events":"auto", "background-color":"","overflow":"auto",'height': 'auto'});
        $("#loader").hide();
      },
      success: function(response) {
         console.log("filter response:!",response)
        $('tbody tr').html('');
        if (response.html) {
          $("#myTable").append(response['html']);
        }
        else{
            $('.ajax-load').show();
            $('.ajax-load').html("<div class='alert alert-danger'><b>No articles found</b></div>");
            return;
        }
      },
      error: function(obj) {
        alert("Server Not Responding...........")
      },
    });

});
// ======Article filters on dashboard ends======= //

// ===== Load more articles dashboard begins
$(window).scroll(function () {
  
    if ($(window).scrollTop() + $(window).height() >= $(document).height()-500) {
        // if($(window).scrollTop() + $(window).height() == $(document).height()) {
            sum = $(window).scrollTop() + $(window).height();
            console.log("result = "+ sum)

        page=page+1;
        keyword = $("#keyword").val();

        if (keyword) {
            loadMoreData(page, keyword);
        } else {
            loadMoreData(page);
        }
    }
});


function loadMoreData(page, keyword = false) {
    priority = $("#priority-filter-table").val();
    status = $("#status-filter-table").val();
    category = $("#category-filter-table").val();
    start_date = $("#post_at").val();
    end_date = $("#post_at_to_date").val();
    if (start_date == '' && end_date == '') {
        start_date = $("#start_date").val();
        end_date = $("#end_date").val();
    }

    console.log("see",start_date,end_date);
    console.log("my check", priority, status, category)

    if (keyword) {
        url = '?page=' + page + "&status=" + status + "&category=" + category + "&priority=" + priority + "&keyword=" + keyword
    } else {
        url = '?page=' + page + "&status=" + status + "&category=" + category + "&priority=" + priority
    }


    $.ajax({
            url: url,
            type: "get",
            beforeSend: function () {
                $('html,body').css({"pointer-events":"none", "background":"#e9e9e9"});
                $("#loader").show();
            },
            data:{
                start_date,
                end_date,
            },
        })
        .done(function (data) {
            $("#loader").hide(); 
            $('html,body').css({"pointer-events":"auto", "background-color":""});
            if (data.html) {
                // console.log(data.html)                
                $("#myTable").append(data['html']);
            } else {
                // console.log("Why not?");
                $('.ajax-load').show()
                $('.ajax-load').html("<div class='alert alert-danger'><b>No more articles found</b></div>");
                return;
            }
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            alert('server not responding...');
        });
}

// ===== Load more articles dashboard ends


// ====Search article using ajax loaded begins
// $("#myInputBtn").on("click", function(){
$("#searchArticleForm").on("submit", function (e) {
    e.preventDefault()
    page=1
    keyword = $("#keyword").val();

    // alert(keyword)
    url = '?page=' + page + "&keyword=" + keyword

    $.ajax({
            url: url,
            type: "get",
            beforeSend: function () {
                $('html,body').css({"pointer-events":"none", "background":"#e9e9e9"});
                $("#loader").show();
                // $('.ajax-load').show();
                // $('#loading_icon').show()
            }
        })
        .done(function (data) {
            $("#loader").hide(); 
            $('html,body').css({"pointer-events":"auto", "background-color":""});
            if (data.html) {
                // $('.ajax-load').hide();
                $("#myTable").replaceWith("<tbody id='myTable'>" + data.html + "</tbody>");
            } else {
                $('.ajax-load').show();
                $('.ajax-load').html("<div class='alert alert-danger'><b>No more articles found</b></div>");
                return;
            }
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            alert('server not responding...');
        });
    // alert("welcome to volv!")
});

// // ====Search article using ajax loaded ends


