@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <h2>Decide if Bias/Unbias News(Level 1):</h2>
      <i class="fa fa-info-circle"></i>&nbsp;<em><small>This News bias detection <span style="color: red; font-weight: bold;">highlights</span> words such as "Warning, Refused etc." which are categorized as biased words. This is Level 1 detection, Level 2 will be upgraded soon.</small> </em>
      <a href="{{ url('/plagiarismChecker') }}" class='btn btn-warning pull-right'>Check Plagiarism</a>
    </div>

    <div class="row">
        <ul style="list-style-type: none;">
            <li class="alert alert-danger summary_length_errors_min"><strong>Wait!</strong> Article Summary length less than 60 words.</li>
        </ul>
        <ul style="list-style-type: none;">
        <li class="alert alert-danger article_summary_char_count_error"><span><b>Wait!</b>&nbsp;Article summary cannot be more than 485 characters.</span></li>
      </ul>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <form id="news_form">
                <div class="form-group">
                <label for="email"><h3>Article:</h3></label>
                <textarea name="article" id="article_summary" class="form-control" id="article" cols="30" rows="10" placeholder="Enter your article here..."></textarea>
                <small><em><b>Input Article Summary</b> Max Length : 70 Words.</em></small>
                <span class="pull-right">Character count:&nbsp;<b><span id="article_summary_char_count">0</span></b></span>            
                <span class="pull-right">Word count:&nbsp;<b><span id="article_summary_count">0&nbsp;&nbsp;</span></b></span>
                </div>
                <button type="submit" class="btn btn-success">Check</button>
            </form>
        </div>
        <div class="col-sm-6">
            <label for="email"><h3>Result:</h3></label>
            <p id="article_output"></p>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <form action="{{ url('/proceedToArticles') }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="result_article" id ="result_article" value="">
            <center><button type="submit" class="btn btn-info btn-lg">Proceed</button></center>
        </form>
    </div>
</div>

<script>
    var input = document.getElementById("article_summary");

$(".alert_summary_error_message").hide()
input.addEventListener("input", function(evt) {
  var words = this.value.split(/\s+/);
  var numWords = words.length;
  $("#article_summary_count").html(numWords)
  // alert(numWords)
  article_summary_char_count = $("#article_summary").val().length
//   console.log(article_summary_char_count)
  $("#article_summary_char_count").html(article_summary_char_count)

  if (article_summary_char_count > 485) {
    $(".article_summary_char_count_error").show();
  }


  var maxWords = 70;
//   alert(numWords)
  if(numWords > maxWords) {
    $(".summary_length_errors_min").hide()
    $(".summary_length_errors").show()
  }
  else if (numWords<=70) {
    // $(".summary_length_errors_min").show()
    $(".alert_summary_error_message").hide()
    $(".summary_length_errors").hide()
  }
});


</script>
<script>
    $(function() {
        $("#news_form").on("submit", function(e) {
            e.preventDefault();
            $.ajax({
            url: '{{url("/submit_news")}}',
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

            },
            success: function(obj) {

                article = $("#article_summary").val()
                $("#result_article").val(article)
                highligh_words = obj

                function replaceAll(str, find, replace) {
                return str.replace(new RegExp(find, 'g'), replace);
                }  
                highligh_words.forEach(element => {
                flag = article.includes(element)
                if(flag) {
                    console.log("article")
                    console.log(article)
                    biased_word = "<strong style='color: #f00;'>"+element+"</strong>"
                    article = replaceAll(article, element, biased_word)
                }
                $("#article_output").html(article)
                });
                $("#article_output").html(article)
            },
            error: function(obj) {
              $(".success_msg").hide();
              console.log(obj.responseJSON.errors)
              $('.errors').show()
              $(".errors").empty()
              $.each(obj.responseJSON.errors, function(key, val) {
                  $('.errors').append("<li class='alert alert-danger'>"+val+"</li>")
              });
            }
          })       
        })
    })
</script>
@endsection