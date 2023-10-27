@extends('layouts.app')

@section('title', 'Polls')

@section('content')

<div class="container">
    <div class="row">
        <h3><u>Add Poll:</u></h3>
        <a href="{{ url('/view_poll') }}" class='btn btn-info pull-right'><i class='fa fa-eye'></i>&nbsp;View Polls</a>
    </div>
    <div class="row">
      <ul style="list-style-type: none;">
        <li class="alert alert-danger poll_question_char_count_error"><span><b>Wait!</b>&nbsp;Poll question cannot be more than 75 characters.</span></li>
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-danger poll_answer1_char_count_error"><span><b>Wait!</b>&nbsp;Poll answer 1 cannot be more than 35 characters.</span></li>
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-danger poll_answer2_char_count_error"><span><b>Wait!</b>&nbsp;Poll answer 2 cannot be more than 35 characters.</span></li>
      </ul>



    </div>
    <div class="row">
        <ul style="list-style-type: none;">
            <li class="alert alert-success success_msg">Poll added successfully.</span></li>
        </ul>
        <ul style="list-style-type: none;">
            <li class="alert alert-warning poll_exists_error">Poll already exists.</span></li>
        </ul>

        
        <div class="col-sm-6">
            <form id="poll_form">
            @csrf
                <div class="form-group">
                    <label for="poll_question">Poll Question&nbsp;<span style="color: red">*</span></label>
                    <textarea name="poll_question" class='form-control' id="poll_question" cols="5" rows="3" placeholder="Enter your poll question here..." required></textarea>
                    <input type="hidden" name="article_id" value="{{ $id }}">
                    <label for="Character count">Character count:&nbsp;<span id="poll_question_character_count">0</span></label>
                </div>

                <div class="form-group">
                    <label for="poll_question">Answer 1&nbsp;<span style="color: red">*</span></label>
                    <textarea name="answer1" class='form-control' id="answer1" cols="5" rows="3" placeholder="Enter your first answer here..." required></textarea>
                    <label for="Character count">Character count:&nbsp;<span id="poll_answer1_character_count">0</span></label>
                </div>

                <div class="form-group">
                    <label for="">Answer 2&nbsp;<span style="color: red">*</span></label>
                    <textarea name="answer2" class='form-control' id="answer2" cols="5" placeholder="Enter your second answer here..." rows="3" required></textarea>
                    <label for="Character count">Character count:&nbsp;<span id="poll_answer2_character_count">0</span></label>

                </div>
                <div class="form-group">
                  <label for="">Poll Image URL</label>
                  <!-- <input type='file' name="poll_image" class='form-control'> -->
                  <input type='url' name="poll_image" placeholder="Paste your poll image url here..." class='form-control'>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">

$(".poll_exists_error").hide()
    $("#poll_form").on("submit", function(e) {
        e.preventDefault();

        $(".success_msg").hide();

        errors = 0

        poll_question_char_count = $("#poll_question").val().length
        answer1_char_count = $("#answer1").val().length
        answer2_char_count = $("#answer2").val().length

        if (poll_question_char_count > 75) {
          errors = errors+1
        }
        
        if (answer1_char_count > 35) {
          errors = errors +1
        }

        if (answer2_char_count > 35) {
          errors = errors +1
        }
        

        if(errors == 0) {

          $.ajax({
              url: '{{url("/store_poll")}}',
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

                // $(".lds-css").show()
              },
              success: function(obj) {
                console.log(obj.status)
                  if (obj.status == "success") {
                    $(".poll_exists_error, .alert-danger").hide()
                    $(".success_msg").show()
                  }
                  console.log(obj.status)
                  if (obj.status == "Poll already exists!") {
                    $(".success_msg, .alert-danger").hide();
                    $(".poll_exists_error").show()
                  }

              },
              error: function(obj) {
                $(".success_msg").hide();
                // alert("error")
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
                $('#loading_icon').hide();
              }
            })


        }
        else {
          return false;
        }
    })    
</script>

<script type="text/javascript">
  $( document ).ready(function() {

    $(".poll_question_char_count_error, .poll_answer1_char_count_error, .poll_answer2_char_count_error").hide()
    var input = document.getElementById("poll_question");

    input.addEventListener("input", function(evt){
      article_heading_char_count = $("#poll_question").val().length
      $("#poll_question_character_count").html(article_heading_char_count)
      if (article_heading_char_count > 75) {
        $(".success_msg").hide()
        $(".poll_question_char_count_error").show();
      }
      else {
        $(".poll_question_char_count_error").hide();
      }
    });

    var input1 = document.getElementById("answer1");

    input1.addEventListener("input", function(evt){
      article_heading_char_count = $("#answer1").val().length
      $("#poll_answer1_character_count").html(article_heading_char_count)
      if (article_heading_char_count > 35) {
        $(".success_msg").hide()
        $(".poll_answer1_char_count_error").show();
      }
      else {
        $(".poll_answer1_char_count_error").hide();
      }
    });


    var input1 = document.getElementById("answer2");

    input1.addEventListener("input", function(evt){
      article_heading_char_count = $("#answer2").val().length
      $("#poll_answer2_character_count").html(article_heading_char_count)
      if (article_heading_char_count > 35) {
        $(".success_msg").hide()
        $(".poll_answer2_char_count_error").show();
      }
      else {
        $(".poll_answer2_char_count_error").hide();
      }
    });


  });
</script>
@endsection