// ====Datepicker for filter by date begins
// var $ = jQuery.noConflict();
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
var page = 1;

//Search by filter starts
$("#searchArticleFormByDates").on('submit',function(e){
    e.preventDefault();
    page=1;
    author = $("#author-filter-table").val();
    priority = $("#priority-filter-table").val();
    status = $("#status-filter-table").val();
    category = $("#category-filter-table").val();
    
    start_date=$('#post_at').val();
    end_date=$('#post_at_to_date').val();
    // if (start_date=='' && end_date==''){
    //     start_date=$("#start_date").val();
    //     end_date=$("#end_date").val();
    // }
    url = '?page='+page+"&author="+author+"&status="+status+"&category="+category+"&priority="+priority

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
            // start_date=$('#post_at').val("");
            // end_date=$('#post_at_to_date').val("");
        },
        success: function(response) {
        //  console.log(response)
        $('tbody tr').html('');
        if (response.html) {
            console.log("data",start_date,end_date);

            $("#myTable").append(response['html']);
        }
        else{
            console.log("dates!!",start_date,end_date);

            $('.ajax-load').show()
            $('.ajax-load').html("<div class='alert alert-danger'><b>No articles found</b></div>");
            return;
        }
        },
        error: function(obj) {
        // alert(obj)
        }
    });

});
//Search by filter ends

//All select tag filters logic
$("#author-filter-table,#priority-filter-table,#status-filter-table,#category-filter-table").on('change',function(e){
    e.preventDefault();
    $("#post_at").val("");
    $("#post_at_to_date").val("");
    $("#post_at").datepicker('setDate', null);
    $("#post_at_to_date").datepicker('setDate', null);
    start_date=$("#start_date").val();
    end_date=$("#end_date").val();
    // console.log("see",start_date,end_date);
    page=1;
    var author=$('#author-filter-table').find(":selected").val();
    var priority=$('#priority-filter-table').children("option:selected").val();
    var status=$('#status-filter-table').children("option:selected").val();
    var category=$('#category-filter-table').children("option:selected").val();
    console.log("dates",start_date,end_date);
    console.log("checking",author,priority,status,category);
    url = '?page='+page+"&author="+author+"&status="+status+"&category="+category+"&priority="+priority
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
        //  console.log(response)
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
        // alert(obj)
      },
    });
    
  });
//All select tag filter logic ends

var words = $('#article_summary').text().split(/ [A-Z|a-z|0-9|(|)]+/);
var numWords = words.length;
$(".article_summary_count").html(numWords)
article_summary_char_count = $("#article_summary").text().length

$("#article_summary_char_count").html(article_summary_char_count)

article_updated_author_list = $(".article_author").text()
article_auth = article_updated_author_list.split(",")
var sum=0;
$(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
        sum = $(window).scrollTop() + $(window).height();
        console.log("result = "+ sum)
        // console.log("Document height")
        // console.log($(document).height())

        page=page+1;
        keyword = $("#keyword").val()
        if (keyword) {
            loadMoreData(page, keyword);
        } else {
            loadMoreData(page);
        }
    }
});


function loadMoreData(page, keyword = false) {

    author = $("#author-filter-table").val();
    priority = $("#priority-filter-table").val();
    status = $("#status-filter-table").val();
    category = $("#category-filter-table").val();
    start_date=$("#post_at").val();
    end_date=$("#post_at_to_date").val();
    if (start_date=='' && end_date==''){
        start_date=$("#start_date").val();
        end_date=$("#end_date").val();
      }
    console.log("check date",start_date,end_date);

    console.log("my check", author, priority, status, category)
    if (keyword) {
        url = '?page=' + page + "&author=" + author + "&status=" + status + "&category=" + category + "&priority=" + priority + "&keyword=" + keyword
    } else {
        url = '?page=' + page + "&author=" + author + "&status=" + status + "&category=" + category + "&priority=" + priority
    }


    $.ajax({
            url: url,
            type: "get",
            beforeSend: function () {
                $('html,body').css({"pointer-events":"none", "background":"#e9e9e9"});
                $("#loader").show();
                    // var scrollTop = ($('html').scrollTop()) ? $('html').scrollTop() : $('body').scrollTop(); // Works for Chrome, Firefox, IE...
                    // $('html').addClass('noscroll').css('top',-scrollTop);    
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
                console.log("Why not?");
                $('.ajax-load').show()
                $('.ajax-load').html("<div class='alert alert-danger'><b>No more articles found</b></div>");
                return;
            }

            // $('html').removeClass('noscroll');
            // $('html,body').scrollTop(sum);
        
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            alert('server not responding...');
        });
}

$(function () {
    $("#searchArticleForm").on("submit", function (e) {
        e.preventDefault();
        page=1
        keyword = $("#keyword").val();
        url = '?page=' + page + "&keyword=" + keyword
        console.log("hi",keyword)
        $.ajax({
                url: url,
                type: "get",
                beforeSend: function () {
                    $('.ajax-load').show();
                    $('#loading_icon').show()
                }
            })
            .done(function (data) {
                if (data.html) {
                    console.log(data)
                    $('.ajax-load').hide();
                    $("#myTable").replaceWith("<tbody id='myTable'>" + data.html + "</tbody>");
                } else {
                    $('.ajax-load').html("<div class='alert alert-danger'><b>No more articles found</b></div>");
                    return;
                }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                alert('server not responding...');
            });
    });

})






// ====Search article using ajax loaded begins

// $("#myInputBtn").on("click", function(){
$("#searchArticleForm").on("submit", function (e) {
    e.preventDefault()

    keyword = $("#keyword").val();

    url = '?page=' + keyword + "&keyword=" + keyword

    $.ajax({
            url: url,
            type: "get",
            beforeSend: function () {
                $('html,body').css({"pointer-events":"none", "background":"#e9e9e9"});
                $("#loader").show();
                // $('.ajax-load').show();
                // $('#loading_icon').show();
            }
        })
        .done(function (data) {
            $("#loader").hide(); 
            $('html,body').css({"pointer-events":"auto", "background-color":""});
            if (data.html) {
                $('.ajax-load').hide();
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

// ====Search article using ajax loaded ends
