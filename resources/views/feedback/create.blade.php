@extends('layouts.app')

@section('title','Create Feedback')
<style type="text/css">
	#feedback_body, #option_count, #slider_min, #slider_max, #slides_section, .feedback_body_char_count_error, .feedback_body_errors_min, .option_count_error, .slides_error {
		display: none;
	}
  .cloned_form {
    display: none;
    /*border: 1px solid #ccc;*/
    /*background-color: #d3d3d3;*/
    /*padding: 3%;*/
  }
  #feedback_form_section1 {
    display: none;
  }

  .col-sm-offset-1.col-sm-6 {
    border-radius: 5px;
    margin-top: 15px;
    margin-bottom: 15px;
    background-color: #d3d3d3;
    width: 60%;
    padding: 2% 3%;    
  }
</style>
@section('content')
<div class="container main">
    <div class="row">
        <h3>Create Feedback:</h3>
    </div>
    <div class="row">

      <ul style="list-style-type: none;">
        <li class="alert alert-danger option_count_error"><strong>Wait! </strong>Option Count cannot be more than 5.</li>
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-danger slides_error"><strong>Wait!</strong>Slides cannot be more than 5.</li>
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
    <div id="feedback_form_section" class="form_no100" data-id="100">
    <div class="row">   
      <div class="col-sm-offset-1 col-sm-6">

          <div class="form-group">
            <label>Feedback Title:</label>
            <input type="text" name="feedback_title[]" id="feedback_title" class="form-control">

              <small><em><b>Feedback Title</b> Word has No Limit.</em></small>
              <span  class="pull-right">Character count:&nbsp;<b><span id="article_summary_char_count">0</span></b></span>            
              <span  class="pull-right">Word count:&nbsp;<b><span id="article_summary_count">0&nbsp;&nbsp;</span></b></span>

          </div>


          <div class="form-group">
            <label>Feedback Type:</label>
    			  <select class="form-control feedback_type" id="feedback_type" name="feedback_type[]">
    			    <option value="0">--Select--</option>
    			    <option value="Text">Text</option>
    			    <option value="Multiple">Multiple</option>
    			    <option value="Slider">Slider</option>
    			  </select>
          </div>

          <div class="form-group"  id="feedback_body">
            <label>Feedback Body:</label>
            <textarea class="form-control" name="feedback_body[]" id="feed_body"></textarea>

              <small><em><b>Feedback Body</b> Max Length : 50 Words.</em></small>
              <span  class="pull-right">Character count:&nbsp;<b><span id="feedback_body_char_count">0</span></b></span>            
              <span  class="pull-right">Word count:&nbsp;<b><span id="feedback_body_count">0&nbsp;&nbsp;</span></b></span>

          </div>




          <div class="form-group" id="option_count">
            <label>Option Count:</label>
            <input type="number" class="form-control option_count" name="option_count[]">
          </div>

          <div class="form-group options_section" id="options">
          </div>

          <div class="form-group" id="slider_min">
            <label>Slider Min:</label>
            <input type="text" class="form-control" name="slider_min[]">
          </div>

          <div class="form-group"  id="slider_max">
            <label>Slider Max:</label>
            <input type="text" class="form-control" name="slider_max[]">
          </div>

          <div class="form-group" id="feedback_img_url">
            <label>Feedback Image URL:</label>
            <input type="text" class="form-control" name="feedback_img_url[]">
          </div>

          <div class="form-group has_slides">
            <label>Has Slides?</label>&nbsp;
			<label class="radio-inline"><input type="radio" class="radio_has_slides" name="has_slides[]" value="Yes">Yes</label>
			<label class="radio-inline"><input type="radio" class="radio_has_slides" name="has_slides[]" value="No">No</label>
         </div>

          <div class="form-group" id="slides_section">
            <label>Slides Count</label>
         </div>




      <div id="feedback_form_section1">
          <div class="row">
            <div class="col-sm-offset-1 col-sm-6">
              
                <div class="form-group">
                  <label>Feedback Title:</label>
                  <input type="text" name="feedback_title[]" id="feedback_title" class="form-control">

                    <small><em><b>Feedback Title</b> Word has No Limit.</em></small>
                    <span  class="pull-right">Character count:&nbsp;<b><span id="article_summary_char_count">0</span></b></span>            
                    <span  class="pull-right">Word count:&nbsp;<b><span id="article_summary_count">0&nbsp;&nbsp;</span></b></span>

                </div>


                <div class="form-group">
                  <label>Feedback Type:</label>
                  <select class="form-control feedback_type" id="feedback_type" name="feedback_type[]">
                    <option value="0">--Select--</option>
                    <option value="Text">Text</option>
                    <option value="Multiple">Multiple</option>
                    <option value="Slider">Slider</option>
                  </select>
                </div>      

          <div class="form-group"  id="feedback_body">
            <label>Feedback Body:</label>
            <textarea class="form-control" name="feedback_body[]" id="feed_body"></textarea>

              <small><em><b>Feedback Body</b> Max Length : 50 Words.</em></small>
              <span  class="pull-right">Character count:&nbsp;<b><span id="feedback_body_char_count">0</span></b></span>            
              <span  class="pull-right">Word count:&nbsp;<b><span id="feedback_body_count">0&nbsp;&nbsp;</span></b></span>

          </div>




          <div class="form-group" id="option_count">
            <label>Option Count:</label>
            <input type="number" class="form-control option_count" name="option_count[]">
          </div>

          <div class="form-group options_section"  id="options">
          </div>

          <div class="form-group" id="slider_min">
            <label>Slider Min:</label>
            <input type="text" class="form-control" name="slider_min[]">
          </div>

          <div class="form-group"  id="slider_max">
            <label>Slider Max:</label>
            <input type="text" class="form-control" name="slider_max[]">
          </div>

                <div class="form-group" id="feedback_img_url">
                  <label>Feedback Image URL:</label>
                  <input type="text" class="form-control" name="feedback_img_url[]">
                </div>
            </div>        

          </div>
      </div>


      </div>

    </div>
  </div>

  <br>
      <center>    
        <button type="submit" class="btn btn-success">Submit</button>
      </center>

    </form>   

    </div>
s </div>
 <script type="text/javascript">
 	$(function() {
 		// $("#feedback_form_section .feedback_type").on("change", function() {

    $("#feedback_form").on("change", '.feedback_type',  function() {
      // alert("d")
      cloned_form_no = $(this).parent().parent().parent().parent().attr('data-id')

 			feedback_type = $(this).val()

 			if (feedback_type == "Text") {
 				$("div.form_no"+cloned_form_no+" #feedback_body").show()
 				$("div.form_no"+cloned_form_no+" #option_count, div.form_no"+cloned_form_no+" .options, div.form_no"+cloned_form_no+" #slider_max, div.form_no"+cloned_form_no+"  #slider_min").hide()
 			}
 			if (feedback_type == "Multiple") {
 				$("div.form_no"+cloned_form_no+" #option_count").show()
 				$("div.form_no"+cloned_form_no+" #feedback_body, div.form_no"+cloned_form_no+" #slider_max, div.form_no"+cloned_form_no+" #slider_min").hide()
 			}
 			if (feedback_type == "Slider") {
 				$("div.form_no"+cloned_form_no+" #slider_min, div.form_no"+cloned_form_no+" #slider_max").show()
 				$("div.form_no"+cloned_form_no+" #feedback_body, div.form_no"+cloned_form_no+" #option_count, div.form_no"+cloned_form_no+" .options").hide()
 			}
 		})



 		$("#feedback_form").on("keyup", '.option_count',  function() {


      cloned_form_no = $(this).parent().parent().parent().parent().attr('data-id')
      console.log("option")
      console.log(cloned_form_no)

 			option_count = $(this).val()
 			$("div.form_no"+cloned_form_no+" #options").empty()

      if (option_count > 5) {
        $("div.form_no"+cloned_form_no+" .option_count_error").show()
      }
      else {
        $("div.form_no"+cloned_form_no+" .option_count_error").hide()
        for (var i = 0; i < option_count; i++) {
          // $('div.form_no'+cloned_form_no+' #options').append("<div class='form-group options'><label>Option"+(i+1)+"</label><input class='form-control' name='option"+(i+1)+"[]' type='text'/></div>")
    
          $('div.options_section').append("<div style='display:none' class='form-group options'><label>Option"+(i+1)+"</label><input class='form-control' name='option"+(i+1)+"[]' type='text'/></div>")
    
        }
        
        $(' div.form_no'+cloned_form_no+' div.options_section .options').show()

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

				$('#slides_section').append("<div class='form-group slides'><label>Slides Count</label><input class='form-control slides_option' name='slides_count[]' type='number'/></div>")
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


    $("#feedback_form").on("keyup", '.slides_option',  function() {

      if ($(this).val() >5) {
        $(".slides_error").show()
      }
      else {
        $(".slides_error").hide()

        $(".cloned_form").remove()
        for (var i = 0; i < $(this).val(); i++) {
          obj = $("#feedback_form_section1").clone()
          // $("#feedback_form_section1").clone().addClass("form_no"+i)
          $("#feedback_form_section1").clone().addClass("cloned_form form_no"+i).attr("data-id", i)
          // $("#feedback_form_section1").clone().attr("data-id", i)
          .appendTo("#feedback_form_section")
          // console.log("Hello")
          // console.log($(this))
          obj.find(":input").val(''); // find all input types (input, textarea etc), empty it.
          obj.find("div#feedback_form_section1").attr('id', ''); // find all input types (input, textarea etc), empty it.
          $(".cloned_form").show()
      }


      }
    })



 	})
 </script>
@endsection