@extends('layouts.app')

@section('title','Create Feedback')
<style type="text/css">
	#feedback_body, #option_count, #slider_min, #slider_max, #slides_section, .feedback_body_char_count_error, .feedback_body_errors_min, .option_count_error {
		display: none;
	}
</style>
@section('content')
<div class="container">
    <div class="row">
        <h3>Create Feedback:</h3>
    </div>
    <div class="row">

      <ul style="list-style-type: none;">
        <li class="alert alert-danger option_count_error"><strong>Wait!</strong>Option Count cannot be more than 5.</li>
      </ul>


      <ul style="list-style-type: none;">
        <li class="alert alert-danger summary_length_errors_min"><strong>Wait!</strong> Article Summary length less than 60 words.</li>
      </ul>


      <ul style="list-style-type: none;">
        <li class="alert alert-danger summary_length_errors"><strong>Wait!</strong> Feedback body words cannot be more than 50.</li>
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-danger article_summary_char_count_error"><span><b>Wait!</b>&nbsp;Feedback Title cannot be more than 70 characters.</span></li>
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-danger feedback_body_errors_min"><strong>Wait!</strong> Feedback Body can be max 50 words.</li>
      </ul>


      <ul style="list-style-type: none;">
        <li class="alert alert-danger feedback_body_char_count_error"><span><b>Wait!</b>&nbsp;Feedback body cannot be more than 240 characters.</span></li>
      </ul>


    <form id="feedback_form" action="{{ url('/store_feedback') }}" method="POST">
    {{ csrf_field() }}
    <div class="row">   
      <div class="col-sm-offset-1 col-sm-6">

          <div class="form-group" id="feedback_img_url">
            <label>Feedback Image URL:</label>
            <img src="{{ $feedback->feedback_image }}" width="200">
            <input type="text" class="form-control" name="feedback_img_url" value="{{ $feedback->feedback_image }}" readonly="">
          </div>

          <div class="form-group">
            <label>Feedback Title:</label>
            <input type="text" name="feedback_title" id="feedback_title" class="form-control" value="{{ $feedback->feedback_title }}">

              <small><em><b>Feedback Title</b> Word has No Limit.</em></small>
              <span  class="pull-right">Character count:&nbsp;<b><span id="article_summary_char_count">0</span></b></span>            
              <span  class="pull-right">Word count:&nbsp;<b><span id="article_summary_count">0&nbsp;&nbsp;</span></b></span>

          </div>

          @if(isset($feedback->feedback_type))
          <div class="form-group">
            <label>Feedback Type:</label>
    
    			  <select class="form-control" id="feedback_type" name="feedback_type">
              @foreach($feedback_option as $feed)
                @if($feed == $feedback->feedback_type)
                  <option value="" selected>{{ $feed }}</option>
                @else
                  <option value="">{{ $feed }}</option>                
                @endif

              @endforeach

    			    <option value="0">--Select--</option>
    			    <option value="Text">Text</option>
    			    <option value="Multiple">Multiple</option>
    			    <option value="Slider">Slider</option>
    			  </select>
          </div>
          @endif


          @if(isset($feedback->feedback_body))
          <label>Feedback Body</label>
          <div class="form-group">
              <textarea class="form-control" readonly>{{ $feedback->feedback_body }}</textarea>
          </div>
          @endif
          @if(isset($feedback->options_count))

          <div class="form-group">
            <label>Option Count:</label>
            <input type="number" class="form-control option_count" name="option_count" value="{{ $feedback->options_count }}" readonly>
          </div>

          <div class="form-group">
              <label>Option 1</label>
              <input type="text" name="feedback_title" id="feedback_title" class="form-control" value="{{ $feedback->option1 }}" readonly>
          </div>
          <div class="form-group">
              <label>Option 2</label>
              <input type="text" name="feedback_title" id="feedback_title" class="form-control" value="{{ $feedback->option2 }}" readonly>
          </div>
          <div class="form-group">
              <label>Option 4</label>

              <input type="text" name="feedback_title" id="feedback_title" class="form-control" value="{{ $feedback->option3 }}" readonly>
          </div>
          <div class="form-group">
              <label>Option 4</label>

              <input type="text" name="feedback_title" id="feedback_title" class="form-control" value="{{ $feedback->option4 }}" readonly>
          </div>
          <div class="form-group">
              <label>Option 5</label>

              <input type="text" name="feedback_title" id="feedback_title" class="form-control" value="{{ $feedback->option5 }}" readonly>
          </div>


          @endif


          @if(isset($feedback->slider_max))
            <div class="form-group">
                <label>Slider Max</label>
                <input type="text" name="slider_max" value="{{ $feedback->slider_max }}" readonly>
            </div>
          @endif


          @if(isset($feedback->slider_min))
            <div class="form-group">
              <label>Slide Min</label>
                <input type="text" name="slider_min" value="{{ $feedback->slider_min }}" readonly>
            </div>
          @endif




          <div class="form-group"  id="options">
          </div>

          <div class="form-group" id="slider_min">
            <label>Slider Min:</label>
            <input type="text" class="form-control" name="slider_min">
          </div>

          <div class="form-group"  id="slider_max">
            <label>Slider Max:</label>
            <input type="text" class="form-control" name="slider_max">
          </div>

          <div class="form-group">
            <label>Left Pixel Color:</label>
            <input type="color" class="form-control" name="slider_max" value="#{{ $feedback->left_color }}">
          </div>


          <div class="form-group">
            <label>Right Pixel Color:</label>
            <input type="color" class="form-control" name="slider_max" value="#{{ $feedback->right_color }}">
          </div>


          <div class="form-group has_slides">
            <label>Has Slides?</label>&nbsp;
			<label class="radio-inline"><input type="radio" class="radio_has_slides" name="has_slides" value="Yes">Yes</label>
			<label class="radio-inline"><input type="radio" class="radio_has_slides" name="has_slides" value="No">No</label>
         </div>

          <div class="form-group" id="slides_section">
            <label>Slides Count</label>
         </div>


      </div>

    </div>
      <center>    
        <button type="submit" class="btn btn-success">Submit</button>
      </center>
    </form>   


    </div>
 </div>
 <script type="text/javascript">
 	$(function() {
 		$("#feedback_type").on("change", function() {
 			feedback_type = $(this).val()
 			if (feedback_type == "Text") {
 				$("#feedback_body").show()
 				$("#option_count, .options,#slider_max, #slider_min").hide()
 			}
 			if (feedback_type == "Multiple") {
 				$("#option_count").show()
 				$("#feedback_body, #slider_max, #slider_min").hide()
 			} 			
 			if (feedback_type == "Slider") {
 				$("#slider_min, #slider_max").show()
 				$("#feedback_body, #option_count, .options").hide()
 			} 
 		})



 		$("#feedback_form").on("keyup", '.option_count',  function() {
 			option_count = $(this).val()
 			$('#options').empty()

      if (option_count > 5) {
        $(".option_count_error").show()
      }
      else {
        $(".option_count_error").hide()
        for (var i = 0; i < option_count; i++) {
          $('#options').append("<div class='form-group options'><label>Option"+(i+1)+"</label><input class='form-control' name='option"+(i+1)+"' type='text'/></div>")
        }

      }

 		})

 		$(".has_slides").on("change", function(){
		 	var isChecked = $('.radio_has_slides').prop('checked');
 			if (isChecked == true) {
 				has_slides = "Yes"	
 			}
 			else {

 				has_slides = "No"	
 			}
 			if (has_slides == "Yes") {
				$('#slides_section').empty();
				$('#slides_section').show();

				$('#slides_section').append("<div class='form-group slides'><label>Slides Count</label><input class='form-control' name='slides_count' type='number'/></div>")
 			}
 		})


    var input = document.getElementById("feedback_title");

    $(".alert_summary_error_message").hide()
    input.addEventListener("input", function(evt) {
      var words = this.value.split(/\s+/);
      var numWords = words.length;
      $("#article_summary_count").html(numWords)
      // alert(numWords)
      article_summary_char_count = $("#feedback_title").val().length
      console.log("article_summary_char_count")
      console.log(article_summary_char_count)
      $("#article_summary_char_count").html(article_summary_char_count)

      if (article_summary_char_count > 70) {
        $(".article_summary_char_count_error").show();
      }
       else {
        $(".article_summary_char_count_error").hide();
       }

    });

    var input1 = document.getElementById("feed_body");

    $(".alert_summary_error_message").hide()
    input1.addEventListener("input", function(evt) {
      var words = this.value.split(/\s+/);
      var numWords = words.length;
      $("#feedback_body_count").html(numWords)
      // alert(numWords)
      article_summary_char_count = $("#feed_body").val().length
      console.log(article_summary_char_count)
      $("#feedback_body_char_count").html(article_summary_char_count)

      if (article_summary_char_count > 240) {
        $(".feedback_body_char_count_error").show();
      }
      else {
        $(".feedback_body_char_count_error").hide();        
      }


      var maxWords = 50;
      if(numWords > maxWords) {
        $(".feedback_body_errors_min").hide()
        $(".summary_length_errors").show()
      }
      else if (numWords<=50) {
        // $(".summary_length_errors_min").show()
        $(".alert_summary_error_message").hide()
        $(".summary_length_errors").hide()
      }
    });



 	})
 </script>
@endsection