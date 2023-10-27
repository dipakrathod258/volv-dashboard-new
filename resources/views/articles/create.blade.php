@extends('layouts.app')

@section('title','Create Article')

@section('content')

<!-- <div id="loading_icon" style="display: none;"> -->

</div>
<div class="container">

  <div class="row">
    <h4>
      <img src="assets/imgs/create_article.png" alt="Create Article Image" title="Create an Article" width="30"/>
      <b>Create Articles</b>
    </h4>
      @if(count($errors) > 0)
        @foreach($errors->all() as $error)
        <div class="alert alert-danger">
          {{$error}}
        </div>
        @endforeach
      @endif

      @if(session('success'))
        <div class="alert alert-success">
          {{session('success')}}
        </div>
      @endif
      

<!-- ===Article create Success message begins===-->

      <div class="alert alert-success alert-dismissible success_msg" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Congratulations!&nbsp;</strong>your article submitted successfully.
      </div>

<!-- ===Article create Success message ends===-->

<!-- ===Article create Errors message begins===-->

      <ul class="errors" style="list-style-type: none;">   
      </ul>

      <ul class="alert alert-danger message" style="list-style-type: none;">
      </ul>

      <ul class="alert alert-danger alert_summary_error_message" style="list-style-type: none;">      
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-danger heading_length_errors"><strong>Wait!</strong> Article Heading length exceeded to more than 12 words.</li>
      </ul>
      
      <ul style="list-style-type: none;">
        <li class="alert alert-danger article_video_link_invalid_msg"><strong>Wait!</strong> Article Video Link is invalid.</li>
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-danger summary_length_errors"><strong>Wait!</strong> Article Summary length exceeded to more than 70 words.</li>
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-danger notification_text_error_min"><strong>Wait!</strong> Notification text length cannot more than 30 words.</li>
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-danger" id="notificatin_text_error"><strong>Wait!</strong> Notification text is required if News type is selected.</li>
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-danger" id="news_type_error"><strong>Wait!</strong> News Type is required if notification text is entered.</li>
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-danger" id="article_bias_error"><strong>Wait!</strong> Article bias is required.</li>
      </ul>

      

      <ul style="list-style-type: none;">
        <li class="alert alert-danger summary_length_errors_min"><strong>Wait!</strong> Article Summary length less than 60 words.</li>
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-danger article_heading_char_count_error"><span><b>Wait!</b>&nbsp;Article heading cannot be more than 70 characters.</span></li>
      </ul>
      <ul style="list-style-type: none;">
        <li class="alert alert-danger article_summary_char_count_error"><span><b>Wait!</b>&nbsp;Article summary cannot be more than 465 characters.</span></li>
      </ul>
      
      <ul style="list-style-type: none;">
        <li class="alert alert-danger main_source_errors"><span><b>Wait!</b>&nbsp;Main source should be a valid URL.</span></li>
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-danger additional_source_errors"><span><b>Wait!</b>&nbsp;Additional source should be a valid URL.</span></li>
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-warning article_exists_error"><span><b>Wait!</b>&nbsp;This article already exists!</span></li>
      </ul>      

      <ul style="list-style-type: none;">
        <li class="alert alert-warning svg_image_error"><span><b>Wait!</b>&nbsp;SVG article image URL is not allowed.</span></li>
      </ul>      

      <ul style="list-style-type: none;">
        <li class="alert alert-warning encoded_image_error"><span><b>Wait!</b>&nbsp;Encoded article image URL is not allowed. Eg. "data://image/jpeg......"</span></li>
      </ul>      


      <!-- <ul style="list-style-type: none;">
        <li class="alert alert-warning sub_category_exists_error"><span><b>Wait!</b>&nbsp;This Sub Category already exists!</span></li>
      </ul>       -->

      



      <!-- <img id="loading_icon" src="{{ url('/assets/images/loading.gif')}}" width="100"> -->
<!-- ===Article create Errors message ends===-->
    
<!-- ====Form to submit an article begins  -->
    <form id="article_form" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="col-sm-6">


          <div class="form-group">
            <label for="pwd">Publishers:</label>
            <select class="form-control" name="publisher_title">
              @foreach($publishers as $publisher)
              <option value="{{$publisher->id}}">{{ $publisher->publisher_title }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label>Article Heading&nbsp;<span class="mandatory">*</span></label>
            <input type="text" class="form-control" id="article_heading" name="article_heading">
            <small><em><b>Input Article Heading</b> Max Length : 12 Words.</em></small>
            <span  class="pull-right">Character count:&nbsp;<b><span id="article_heading_character_count">0</span></b></span>
            <span  class="pull-right">Word count:&nbsp;<b><span id="article_heading_count">0&nbsp;&nbsp;</span></b></span>&nbsp;
          </div>
            <label>Bias Legends</label>
            <ul class="list-inline">
              <li style="color: #4cae4c; font-weight: bold;">Left</li>
              <li style="color: #c9302c;font-weight: bold;">Right</li>
              <li style="color: #286090; font-weight: bold;">Center</li>
            </ul>
          <div class="form-group article_h">
              
          </div>

          <div class="form-group">
            <label for="pwd">Notification Text:</label>
            <textarea name="notification_text" id="notification_text" class="form-control"  cols="50" rows="5"></textarea>
            <small><em><b>Input Article Heading</b> Max Length : 20 Words.</em></small>
            <!-- <span  class="pull-right">Character count:&nbsp;<b><span id="notification_text_character_count">0</span></b></span> -->
            <span  class="pull-right">Word count:&nbsp;<b><span id="notification_text_count">0&nbsp;&nbsp;</span></b></span>&nbsp;

          </div>

          <div class="form-group">
            <label>News Type:</label><br>
            <label class="radio-inline"><input type="radio" name="news" id="breaking_news" value="breaking_news">Breaking News</label>
            <label class="radio-inline"><input type="radio" name="news" id="trending_news" value="trending_news">Trending News</label>
            <a id="clear_btn" class="btn btn-primary" style="border-radius: 25px;">Clear</a>
          </div>


          <div class="form-group">
            <label for="pwd">Article Bit&nbsp;<span class="mandatory">*</span></label>
            
              <textarea name="article_summary" id="article_summary" value="{{$article}}" class="form-control" cols="50" rows="5">{{$article}}</textarea>
              <small><em><b>Input Article Summary</b> Max Length : 70 Words.</em></small>
              <span  class="pull-right">Character count:&nbsp;<b><span id="article_summary_char_count">0</span></b></span>            
              <span  class="pull-right">Word count:&nbsp;<b><span id="article_summary_count">0&nbsp;&nbsp;</span></b></span>
              <br>
              <button type="button" id="check_bias_btn" class="btn btn-info">Check Bias</button>
          
          </div>

            <label>Bias Legends</label>
            <ul class="list-inline">
              <li style="color: #4cae4c; font-weight: bold;">Left</li>
              <li style="color: #c9302c;font-weight: bold;">Right</li>
              <li style="color: #286090; font-weight: bold;">Center</li>
            </ul>
              
          <div class="form-group art">
              
          </div>

          <div class="form-group">
            <!-- <label for="sel1">Article Author</label> -->
            <input type="hidden" name="article_author" value="{{auth()->user()->name}}" class="form-control" readonly="">
           </div>

           <div class="form-group">
            <label>Main Source of Article&nbsp;<span class="mandatory">*</span></label>
            <input type="url" id="main_article_source" class="form-control" name="main_source">
            <small><em><b>Format Article Source must Valid Url,</b> Valid Url.</em></small>
          </div>

          <div class="form-group">
            <label>Is main source article bias?&nbsp;<span class="mandatory">*</span>:</label><br>
            <label class="radio-inline"><input type="radio" name="bias" id="left_bias" value="left">Left</label>
            <label class="radio-inline"><input type="radio" name="bias" id="right_bias" value="right">Right</label>
            <label class="radio-inline"><input type="radio" name="bias" id="center_bias" value="center">Center</label>
            <a id="bias_clear_btn" class="btn btn-primary" style="border-radius: 25px;">Clear</a>
          </div>
          <!-- <div class="form-group">
            <label>Is embedded link?&nbsp;<span class="mandatory">*</span>:</label><br>
            <label class="radio-inline"><input type="radio" name="embedded" id="embedded_yes" value="Yes">Yes</label>
            <label class="radio-inline"><input type="radio" name="embedded" id="embedded_no" value="No">No</label>
            <a id="embedded_link_clear_btn" class="btn btn-primary" style="border-radius: 25px;">Clear</a>
          </div> -->


          <div class="form-group">
            <label>Additional Source of Article&nbsp;</label>
            <input type="url" id="additional_article_source" class="form-control" name="additional_source">
            <small><em><b>Format Article Source must Valid Url,</b> Valid Url.</em></small>
          </div>


      </div>

      <div class="col-sm-6">

      <div class="form-group">
            <label>Is additional source article bias?:</label><br>
            <label class="radio-inline"><input type="radio" name="additional_bias" id="add_left_bias" value="left">Left</label>
            <label class="radio-inline"><input type="radio" name="additional_bias" id="add_right_bias" value="right">Right</label>
            <label class="radio-inline"><input type="radio" name="additional_bias" id="add_center_bias" value="center">Center</label>
            <a id="additional_bias_clear_btn" class="btn btn-primary" style="border-radius: 25px;">Clear</a>
          </div>

          <div class="form-group">
            <label>Is this article republishable?: <i class="fa fa-info-circle" title="If you select this field, You can republish this article in future whenever you want."></i> </label><br>
            <label class="radio-inline"><input type="radio" name="republishable" id="republishable" value="republishable">Republishable</label>
            <a id="republishable_clear_btn" class="btn btn-primary" style="border-radius: 25px;">Clear</a>
          </div>


          <div class="form-group">
            <!-- <label>Article Image URL&nbsp;<span class="mandatory">*</span></label> -->
            <label>Article Image URL&nbsp;</label>
            <input type="url" class="form-control" name="article_image_url">
            <!-- <small><em><b>File extension must be</b> JPG,PNG, <b>Max dimension</b> 1920 X 1080, <b>Max file size</b> 1024 kb.</em></small> -->
          </div>


          <div class="form-group">
            <label>Browse Article Image&nbsp;<span>(Optional)</span></label>
            <input type="file" class="form-control" name="browse_article_image">
          </div>

          <div class="form-group">
            <label>Article Video URL&nbsp;</label>
            <input type="url" class="form-control" name="article_video_link">
          </div>

          <div class="form-group">
            <label>Categories(#Hashtags)&nbsp;<span class="mandatory">*</span></label>
            <select class="form-control" name="article_category[]" multiple="multiple" id="article_category">

            @foreach($categories as $category)
              <option value="{{ $category->category_title }}">#{{ $category->category_title }}</option>
            @endforeach
            </select>
            <small><em><b>Input Article Categories</b>&nbsp;Max Length : 250, Select Options: min=1 & max=4</em></small>
          </div>  



          <div class="form-group">
            <label>Sub-categories/Mini-hashtags(Optional)</label>
            <select class="form-control" name="article_sub_category[]" multiple="multiple" id="sub_category">

            @foreach($sub_categories as $data)
              <option value="{{ $data->sub_category }}">#{{ $data->sub_category }}</option>
            @endforeach
            </select>
          </div>  




          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Read more text&nbsp;<span class="mandatory">*</span></label>
                <select class="form-control" name="read_more_text" id="read_more_text">
                  <option value="Check it out">Check it out</option>
                  <option value="Check out the post">Check out the Post</option>
                  <option value="Check out the video">Check out the Video</option>
                  <option value="Check out the insta">Check out the Insta</option>
                  <option value="Check out newsletter">Check out newsletter</option>
                  <option value="Check out the TikTok">Check out the TikTok</option>
                  <option value="Make a donation">Make a Donation</option>
                </select>
              </div>  
            </div>


            <div class="col-sm-6">
              <div class="form-group">
                <label>Read more text color&nbsp;(Default)</label>
                <input type="color" name="read_more_text_color" class="form-control" value="#FFB37D">
              </div>  
            </div>

          </div>


          <!-- <div class="col-xs-12 col-lg-12 col-sm-8 col-md-8 form-group" id="hashtag_structure" style="border: 1px solid #ccc; background-color: #FFE1D0; padding: 8px; border-radius: 10px;">
          <label>#Hashtags:</label>


            <div class=" pull-right">
              <a class="btn" style="background-color: #E86B34; color: #fff" id="add_hashtag_structure_btn" title="Add Deal">
                <i class="fa fa-plus"></i>
              </a>
              <a class="btn" style="background-color: #E86B34; color: #fff" id="remove_hashtag_structure_btn" title="Remove Deal">
                <i class="fa fa-minus"></i>
              </a>

            </div>
            <hr style="color: #FFE1D0">
            <div class="row hashtags" id="1" >


              <div class="col-sm-5">
                <div class="form-group">
                  <label>Category Hashtags:</label>
                  <select class="form-control" name="article_category[]">
                  <option value="--Select--">--Select--</option>
                  @foreach($categories as $category)
                    <option value="{{ $category->category_title }}">#{{ $category->category_title }}</option>
                  @endforeach
                  </select>
                </div>

              </div>

              <div class="col-sm-6 timeline_hashags">
                <div class="form-group">
                  <label class="select">Timeline Hashtags:</label>
                  <input type="text" class="form-control">
                </div>
              </div>



            </div>
          </div> -->


<!--           <div class="form-group">
            <label>Trending Categories</label>
            <select class="form-control" name="trending_category[]"  multiple = "multiple" id="trending_category">
              @foreach($trending_categories as $trending_category)
              <option value="{{ $trending_category->trending_title }}">{{ $trending_category->trending_title }}</option>
              @endforeach
            </select>
            <small><em><b>Input Article Trending Categories</b> Max Length : 250.</em></small>
          </div>
 -->


          <div class="form-group" style="margin-top: 10px">
            <label>Enable ACT Now?&nbsp;</label>
            <label class="radio-inline"><input id="act_now_yes" type="radio" name="act_now">Yes</label>
            <label class="radio-inline"><input id="act_now_no" type="radio" name="act_now" checked>No</label>
          </div>

          <div class="form-group campaign_flag">
            <label>
            Select Campaign</label>
            <select class="form-control" name="campaign" id="campaign">
              <option value="Campaign 1">Campaign 1</option>
              <option value="Campaign 2">Campaign 2</option>
            </select>
          </div> 

          <div class="form-group">
            <label>Keywords</label>
            <textarea name="article_keywords" class="form-control"></textarea>
          </div>   


          <div class="col-xs-12 col-lg-12 col-sm-8 col-md-8" id="deal_structure">

            <a class="btn btn-info" id="add_deal_structure_btn" title="Add Deal">
              <i class="fa fa-plus"></i>
            </a>

            <a class="btn btn-info" id="remove_deal_structure_btn" title="Remove Deal">
              <i class="fa fa-minus"></i>
            </a>


            <div class="row deal" id="1" style="background-color: #337AB7; color: #fff;margin-top: 15px;  padding: 2%; border-radius: 5px;">


              <div class="col-sm-9">
                <div class="form-group">
                  <label>Biased Sentence</label>
                  <textarea type="textarea" name="biased_sentence[]" class="form-control" placeholder="Enter biased sentences"></textarea>
                </div>
              </div>

              <div class="col-lg-offset-0 col-lg-3 col-xs-12 col-sm-12">
                <div class="form-group">
                  <label class="select">Biased Type:</label>
                  <select name="biased_type[]" class="form-control">
                    <option>--select--</option>
                    <option value="Positive">Positive</option>
                    <option value="Negative">Negative</option>
                    <option value="Left">Left</option>
                    <option value="Right">Right</option>
                  </select>
                </div>
              </div>
            </div>
          </div>










                <!-- <div class="form-group">
                  <label>
                    <img src="assets/icons/united-states.svg" width="20" alt="USA Flag" title="United States of America">
                  Targetting States</label>
                <i class="fas fa-flag-usa"></i>
                  <select class="form-control" name="targetting_states[]" id="targetting_state" multiple="multiple">
                    <option value="0">--Select State--</option>
                  </select>
                </div> -->

                <!-- <div class="form-group">
                  <div class="row">
                    <div class="col-sm-9">
                      <label>Biased sentences&nbsp;</label>
                      <textarea type="textarea" id="additional_article_source" class="form-control" name="additional_source"></textarea>
                    </div>
                    <div class="col-sm-3">
                    <label>Type of bias&nbsp;</label>
                    
                      <select class="form-control" name="biased_sentencce">
                        <option value="0">Left</option>
                        <option value="0">Right</option>
                        <option value="0">Positive</option>
                        <option value="0">Negative</option>
                      </select>
                    </div>
                  </div>
                </div> -->

                
                <!-- <label for="">Targetting Hyperlink</label>
                
                <div class="input-group">
                  <input id="email" type="text" class="form-control" name="hyperlink_keyword" placeholder="Enter hyperlink word...">
                </div>
                <br>
                <div class="input-group">
                  <input id="email" type="text" class="form-control" name="targetting_hyperlink_articles" placeholder="Search Article here...">
                  <span class="input-group-addon"><i class="fa fa-search"></i></span>
                </div> -->
              <br>


      <!--           <div class="form-group">
                  <label>Article left gradient&nbsp;<span class="mandatory">*</span></label>
                  <input type="color" class="form-control" id="article_left_gradient" name="article_left_gradient">
                </div>
      --> 
      <!--           <div class="form-group">
                  <label>Article Image URL&nbsp;<span class="mandatory"></span></label>
                  <input type="url" class="form-control" id="article_image_url" name="article_image_url">
                </div>
      -->      </div>
          </div>
          <center>
            <input type="submit" class="btn btn-success">
          </center>
  </form>


<!-- ====Form to submit an article ends  -->
</div>

    <!-- Modal -->


    <div id="check_bias_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width: 1600px !important;">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="font-weight: bold;">Article Bias Summary:</h4>
        </div>
        <div class="modal-body">
          <h4><b id="article_heading_text"></b></h4>
          <!-- <ul>
            <li>Gold is typically seen as a hedge against inflation.<b style="color: blue;">(Left)</b></li>
            <li>But in the wake of COVID-19, the price of gold is rising due to deflation caused by the pandemic-induced recession.</li>
            <li>With high unemployment, low consumer demand has offset the reduction in supply from shuttered factories, keeping inflation low.</li>
            <li>With central banks slashing interest rates to fight deflation, the yield on 10-year Treasuries is negative.<b style="color: red;">(Right)</b></li>
            <li>So, gold has become a preferred asset.</li>
          </ul>            -->

          <table class="table table-bordered table-hover table-striped">
            <thead>
                <th>Article Sentence</th>
                <th>Bias Type</th>
                <th>Change Bias</th>
            </thead>
            <tbody>
            </tbody>
          </table>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>






<script type="text/javascript">
  $(function() {
    $("#article_bias_error").hide()
    $('#loading_icon, .article_video_link_invalid_msg').hide();

    $(".errors").hide()
    states="Alabama|Alaska|Arizona|Arkansas|California|Colorado|Connecticut|Delaware|District of Columbia|Florida|Georgia|Hawaii|Idaho|Illinois|Indiana|Iowa|Kansas|Kentucky|Louisiana|Maine|Maryland|Massachusetts|Michigan|Minnesota|Mississippi|Missouri|Montana|Nebraska|Nevada|New Hampshire|New Jersey|New Mexico|New York|North Carolina|North Dakota|Ohio|Oklahoma|Oregon|Pennsylvania|Rhode Island|South Carolina|South Dakota|Tennessee|Texas|Utah|Vermont|Virginia|Washington|West Virginia|Wisconsin|Wyoming";
    states_list = states.split("|")
    for (i=0;i<states_list.length;i++) {
      $("#targetting_state").append("<option value="+states_list[i]+">"+states_list[i]+"</option>")
    }
    $("#article_category, #trending_category, #targetting_state, #sub_category").select2({
      tags: true
    });

    $("#article_category, #trending_category, #targetting_state, #sub_category").on("select2:select", function (evt) {
      var element = evt.params.data.element;
      var $element = $(element);
      
      $element.detach();
      $(this).append($element);
      $(this).trigger("change");
    });

    $("#article_category").on("change", function() {
      article_category = $(this).val();

      $.ajax({
        url: "{{ url('/getMiniHashtags') }}",
        method: "POST",
        dataType: "JSON",
        headers:{
                 'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },   
        data: {"article_categories": article_category},
        success: function(obj) {
          // alert("success")
          $("#sub_category").empty()
          $.each(obj, function(key, val) {
            console.log(key);
              $("#sub_category").append("<option values="+val+">#"+val+"</option>")
          })

          @foreach($sub_categories as $data)
              $("#sub_category").append("<option value='{{ $data->sub_category }}'>#{{ $data->sub_category }}</option>")              
          @endforeach


        },
        error: function(obj) {
          alert("Error")
        }
      })

    })


    // $("#article_summary").summernote()
    $("#url_btn").click(function() {
      var elm;

      function isValidURL(u){
        if(!elm){
          elm = document.createElement('input');
          elm.setAttribute('type', 'url');
        }
        elm.value = u;
        return elm.validity.valid;
      }

      web_url = $("#url").val()
      console.log(web_url)
      console.log(isValidURL(web_url));
    })

    var input = document.getElementById("article_heading");

    $(".message").hide();
    input.addEventListener("input", function(evt){
      // var words = $('#article_heading').val().split(/ [A-Z|a-z|0-9|(|)]+/);
      // console.log(words)
      // var numWords = words.length;
      // console.log(numWords)
       article_heading_char_count = $("#article_heading").val().length
      //  console.log("article_heading_char_count")
      //  console.log(article_heading_char_count)
      $("#article_heading_character_count").html(article_heading_char_count)
       if (article_heading_char_count > 70) {
          $(".article_heading_char_count_error").show();
       }
       else {
        $(".article_heading_char_count_error").hide();
       }


      // $("#article_heading_count").html(numWords)
      // var maxWords = 12;
      // if(numWords > maxWords) {
      //   $(".heading_length_errors").show()

      //   $("#alert_message").css("transition","1s")
      //   evt.preventDefault();
      // }
      // else if (numWords<=12) {
      //   $(".heading_length_errors").hide()
      //   $(".message").hide()
      // }
    });

    var input = document.getElementById("article_summary");

    $(".alert_summary_error_message").hide()
    input.addEventListener("input", function(evt) {
      var words = this.value.split(/\s+/);
      var numWords = words.length;
      $("#article_summary_count").html(numWords)
      // alert(numWords)
      article_summary_char_count = $("#article_summary").val().length
      console.log(article_summary_char_count)
      $("#article_summary_char_count").html(article_summary_char_count)

      if (article_summary_char_count > 465) {
        $(".article_summary_char_count_error").show();
      }
      else if(article_summary_char_count <= 465) {

        $(".article_summary_char_count_error").hide();
      }


      // var maxWords = 70;
      // if(numWords > maxWords) {
      //   $(".summary_length_errors_min").hide()
      //   $(".summary_length_errors").show()
      // }
      // else if (numWords<=70) {
      //   // $(".summary_length_errors_min").show()
      //   $(".alert_summary_error_message").hide()
      //   $(".summary_length_errors").hide()
      // }
    });


// ======Notification text show no of words real time begins===

    var input = document.getElementById("notification_text");

    $(".notification_text_error_message").hide()
    input.addEventListener("input", function(evt) {
      // var words = this.value.split(/ [A-Z|a-z|0-9|(|)]+/);
      var words = this.value.split(/\s+/);
      
      var numWords = words.length;
      $("#notification_text_count").html(numWords)
      var maxWords = 30;
      // alert(numWords)
      if(numWords > maxWords) {
        $(".notification_text_error_min").show()
        // $(".summary_length_errors").show()
      }
      else if (numWords<=30) {
        $(".notification_text_error_min").hide()
        // $(".summary_length_errors_min").show()
        // $(".alert_summary_error_message").hide()
        // $(".summary_length_errors").hide()
      }
    });


// ======Notification text show no of words real time begins===

    

    $(".campaign_flag").hide()
    $("#act_now_yes").click(function(){
        $(".campaign_flag ").show()
    });
    $("#act_now_no").click(function(){
        $(".campaign_flag").hide()
    });
    var elm;
    function isValidURL(u){
      if(!elm){
        elm = document.createElement('input');
        elm.setAttribute('type', 'url');
      }
      elm.value = u;
      console.log("elm.validity.valid")
      console.log(elm.validity.valid)
      return elm.validity.valid;
    }


// ===News Type clear logic begins

  $("#clear_btn").on("click", function() {
    $("#breaking_news, #trending_news").prop('checked', false);
  })

  $("#bias_clear_btn").on("click", function() {
    $("#left_bias, #right_bias, #center_bias").prop('checked', false);
  })

  $("#additional_bias_clear_btn").on("click", function() {
    $("#add_left_bias, #add_right_bias, #add_center_bias").prop('checked', false);
  })

  $("#republishable_clear_btn").on("click", function() {
    $("#republishable").prop('checked', false);
  })
// ===News Type clear logic ends


        $("#loading_icon").hide()
// =======Creating an article through AJAX starts
        $('#article_form').on('submit', function(e) {
            e.preventDefault();

          error_counter = 0

// ======Article Heading error handling begins===

          var words = $('#article_heading').val().split(/ [A-Z|a-z|0-9|(|)]+/);
          // var numWords = words.length;
          article_heading_char_count = $("#article_heading").val().length
           
           // if (article_heading_char_count > 70) {
           //    error_counter=error_counter+1
           //    $(".article_heading_char_count_error").show();
           // }
           // else if (article_heading_char_count < 75) {      
           //    $(".article_heading_char_count_error").hide();
           // }

          // if(numWords > 12) {
          //   error_counter= error_counter+1
          //   $(".heading_length_errors").show()
          // }
          // else if(numWords<=12) {
          //   $(".message, .heading_length_errors").hide()
          // }

// ======Article Heading error handling ends===

// ======Notification text error handling begins===

          var words = $('#notification_text').val().split(/ [A-Z|a-z|0-9|(|)]+/);
          var numWords = words.length;
          //  article_heading_char_count = $("#notification_text").val().length
           
          if(numWords > 30) {
            error_counter= error_counter+1
            $(".notification_text_error").show()
          }
          else if(numWords<=30) {
            $(".message, .notification_text_error").hide()
          }

// ======Notification error handling ends===


// ======Article News type & notification text mandate validation begins 

        // breaking_news_flag = $("#breaking_news").val()
        // trending_news_flag = $("#trending_news").val()
        notification_text = $("#notification_text").val()
        news_type = $('input[name="news"]:checked').val();
        if(news_type!=undefined && notification_text=="") {
          $("#notificatin_text_error").show()
          $("#news_type_error").hide()
          error_counter=error_counter+1
        }
        if(news_type==undefined && notification_text=="") {
          $("#notificatin_text_error, #news_type_error").hide()
        }

        if(news_type==undefined && notification_text!="") {
          $("#news_type_error").show()
          $("#notificatin_text_error").hide()
          error_counter=error_counter+1
        }


// ======Article News type & notification text mandate validation ends 


// ======Article bias validation begins 
        // $("#article_bias_error").hide()
        article_bias = $('input[name="bias"]:checked').val();
        console.log("article_bias")
        console.log(article_bias)

        if(article_bias==undefined) {
          console.log("andar")
          $("#article_bias_error").show()
          error_counter=error_counter+1
        }
        // console.log("bahar")

        // else {
        //   $("#article_bias_error").hide()
        // }

// ======Article bias validation ends 


// ======Article Summary error handling begings===
          var words = $('#article_summary').val().split(' ');
          var numWords = words.length;
          article_summary_char_count = $("#article_summary").val().length
          if (article_summary_char_count > 465) {
            $(".article_summary_char_count_error").show();
            error_counter=error_counter+1
          }
          else if (article_summary_char_count <= 465) {
            $(".article_summary_char_count_error").hide();
          }
          // alert(numWords)
          // var maxWords = 70;
          // if(numWords > maxWords) {
          //   $(".summary_length_errors_min").hide()
          //   $(".summary_length_errors").show()
          //   error_counter=error_counter+1
          // }
          // else if (numWords<60) {
          //   $(".summary_length_errors").hide()
          //   $(".summary_length_errors_min").show()
          //   error_counter=error_counter+1
          // }
          else if (numWords==maxWords) {
            $(".summary_length_errors, .summary_length_errors_min").hide()
          }

// ======Article Summary error handling ends===

// ======Main Source URL format error handling begins===

          additional_article_source = $("#additional_article_source").val()
          main_article_source = $("#main_article_source").val()

          $(".main_source_errors").hide()            
          // flag = articleHeadCount(article_heading)
          // alert("flag")
          // alert(flag)

          if (!isValidURL(main_article_source)) {
            // console.log(!isValidURL(main_article_source))
            $(".main_source_errors").show()            
            error_counter= error_counter+1
          }
          $(".additional_source_errors").hide()    
          if (!isValidURL(additional_article_source)) {
            $(".additional_source_errors").show()
            error_counter= error_counter+1
          }
          // alert("error_counter")
          // alert(error_counter)
// ======Main Source URL format error handling ends===
          console.log(new FormData(this))
          if (error_counter==0) {
            $.ajax({
              url: '{{url("/submit_article")}}',
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
                $('#loading_icon').css("display", "block !important");

                // $(".lds-css").show()
              },
              success: function(obj) {
                // console.log(obj);
                // alert("success")
                // $(".alert-danger").remove();
                count=0;
                for(i=0;i<obj.length;i++) {
                  if(obj[i]!='') {
                    count++;
                  }
                }
                console.log(obj.status)
                  if (obj.status == "success") {
                    $(".article_exists_error, .alert-danger, .svg_image_error").hide()
                    $(".success_msg").show()

                    setTimeout(()=>{
                      window.location = "{{url('/allDashboard')}}";
                    },3000);

                  }
                  if (obj.status == "article video link invalid") {
                    $(".article_exists_error, .alert-danger, .svg_image_error").hide()
                    $(".article_video_link_invalid_msg").show()
                  }

                  console.log(obj.status == "This article already exists!")
                  if (obj.status == "This article already exists!") {
                    $(".success_msg, .alert-danger, .svg_image_error, .encoded_image_error").hide();
                    $(".article_exists_error").show()
                  }

                  if (obj.status == "This sub category already exists!") {
                    $(".success_msg, .alert-danger, .svg_image_error, .encoded_image_error").hide();
                    $(".sub_category_exists_error").show()
                  }


                  if (obj.status == "Article image URL is of SVG image") {
                    $(".success_msg, .alert-danger, .article_exists_error, .encoded_image_error").hide();
                    $(".svg_image_error").show()
                  }



                  if (obj.status == "Encoded Article Image URL no allowed. Eg, 'data://image/jpeg......'") {
                    $(".success_msg, .alert-danger, .article_exists_error, .svg_image_error").hide();
                    $(".encoded_image_error").show()
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

        })
// =======Creating an article through AJAX ends

  })  


  var id = 2
    $('#add_deal_structure_btn').on('click', function() {
      var clone = $('#deal_structure div.deal:eq(0)').clone(true).find("textarea").val("").end();
      clone.find('[id]').each(function(i, c) {
        $(c).attr('id', $(c).attr('id') + counter());
        $(c).attr('placeholder', $(c).attr('id'));
      });
      clone.attr("id", id);
      $('#deal_structure').append(clone)
      id++;
      var datepicker = new ej.calendars.DatePicker({});
      datepicker.appendTo('#datepicker');

    });

    $('#remove_deal_structure_btn').on('click', function() {
      if ($('#deal_structure div.deal').length != 1)
        $('#deal_structure div.deal:last').remove();
    });


// ===============Clone Hashtags section begins

var id = 2
    $('#add_hashtag_structure_btn').on('click', function() {
      var clone = $('#hashtag_structure div.hashtags:eq(0)').clone(true).find("select, input").val("").end();
      clone.find('[id]').each(function(i, c) {
        $(c).attr('id', $(c).attr('id') + counter());
        $(c).attr('placeholder', $(c).attr('id'));
      });
      clone.attr("id", id);
      $('#hashtag_structure').append(clone)
      id++;
      // var datepicker = new ej.calendars.DatePicker({});
      // datepicker.appendTo('#datepicker');

    });

    $('#remove_hashtag_structure_btn').on('click', function() {
      if ($('#hashtag_structure div.hashtags').length != 1)
        $('#hashtag_structure div.hashtags:last').remove();
    });


// ===============Clone Hashtags section ends


    $('#add_director_structure_btn').on('click', function() {
      var clone = $('#director_structure div.deal:eq(0)').clone(true).find("input").val("").end();
      clone.find('[id]').each(function(i, c) {
        $(c).attr('id', $(c).attr('id') + counter());
        $(c).attr('placeholder', $(c).attr('id'));
      });
      $('#director_structure').append(clone)
    });
    $('#remove_director_structure_btn').on('click', function() {
      if ($('#director_structure div.deal').length != 1)
        $('#director_structure div.deal:last').remove();
    });


// ========Check Bias API call to ML model starts

    $("#check_bias_btn").on("click", function() {
      // alert("dddd")
      article = $("#article_summary").val()
      article_heading = $("#article_heading").val()
        console.log("article_heading")
        console.log(article_heading)

      $.ajax({
            url: '{{ url("/readMediaBias") }}',
            headers:{
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            method: 'GET',
            dataType: 'JSON',
            data:  {"article": article},
            beforeSend: function() {
                $('#loading_icon').show();
            },
            success: function(obj) {
              // alert("success")
              console.log("obj")
              console.log($.type(obj))
              $("#article_heading_text").text(article_heading)
              $("#check_bias_modal table tbody").empty()
                i=0
              $.each(obj, function(key, val) {
                console.log(key)
                console.log(val)
                if(val == "Right") {
                  $("#check_bias_modal table tbody").append("<tr id='"+i+"' style='color: #C9302C'><td>"+key+"</td><span class='article_sentence'>'"+key+"'</span><input type='hidden' class='article_heading' name='article_heading' value='"+article_heading+"'><input type='hidden' class='article_sentence' name='article_sentence' value='"+key+"'><td>"+val+"</td><td><input type='hidden' class='bias_type' value='"+val+"'><select class='form-control change_bias' id='"+i+"' name='bias_type'><option value='0'>--Select--</option><option value='Left'>Left</option><option value='Right'>Right</option><option value='Center'>Center</option></select></td></tr>")
                }
                else if(val == "Left") {
                  $("#check_bias_modal table tbody").append("<tr id='"+i+"' style='color: #449D44'><td>"+key+"</td><span class='article_sentence'>'"+key+"'</span><input type='hidden' class='article_heading' name='article_heading' value='"+article_heading+"'><span class='article_sentence'>'"+key+"'</span><input type='hidden' class='article_sentence' name='article_sentence' value='"+key+"'><td>"+val+"</td><td><input type='hidden' class='bias_type' value='"+val+"'><select class='form-control change_bias' id='"+i+"' name='bias_type'><option value='0'>--Select--</option><option value='Left'>Left</option><option value='Right'>Right</option><option value='Center'>Center</option></select></td></tr>")
                }
                else if(val == "Centre") {
                  $("#check_bias_modal table tbody").append("<tr id='"+i+"' style='color: #449D44'><td>"+key+"</td><span class='article_sentence'>'"+key+"'</span><input type='hidden' class='article_heading' name='article_heading' value='"+article_heading+"'><span class='article_sentence'>'"+key+"'</span><input type='hidden' class='article_sentence' name='article_sentence' value='"+key+"'><td>"+val+"</td><td><input type='hidden' class='bias_type' value='"+val+"'><select class='form-control change_bias' id='"+i+"' name='bias_type'><option value='0'>--Select--</option><option value='Left'>Left</option><option value='Right'>Right</option><option value='Center'>Center</option></select></td></tr>")
                }

                $("#check_bias_modal").modal()
                i+=1
            });

              console.log(obj)              

            },
            error: function(obj) {
              alert("error")
            },
            complete: function() {
                $('#loading_icon',".lds-css").hide();
                $('#loading_icon').hide();
              }
          })
    })
// ========Check Bias API call to ML model ends



    $("#article_summary").on("keyup", function() {
      // alert("dddd")
      // if()
      article = $(this).val()
      console.log("=====xxxx")
      var lastChar = article[article.length -1];
      console.log(lastChar)
      console.log("=====yyy")

      // alert($(this).val())

  // if (lastChar == ".") {
  //     $.ajax({
  //           url: '{{ url("/readMediaBias") }}',
  //           headers:{
  //               'X-CSRF-TOKEN': "{{ csrf_token() }}"
  //           },
  //           method: 'GET',
  //           dataType: 'JSON',
  //           data:  {"article": article},
  //           beforeSend: function() {
  //               $('#loading_icon').show();
  //           },
  //           success: function(obj) {
  //             // alert("success")
  //             console.log("obj")
  //             console.log($.type(obj))
  //             console.log(obj)

  //             $(".art").empty()
  //             $.each(obj, function(key, val) {
  //               console.log(key)
  //               console.log(val)
  //               if(val == "Centre") {
  //                 to_be_replaced = " <span style='color:#c9302c;font-weight: bold;'>"+key+"</span> "
  //               }
  //               else if(val=="Left") {
  //                 to_be_replaced = " <span style='color:#4cae4c;font-weight: bold;'>"+key+"</span> "
  //               }
  //               else {
  //                 to_be_replaced = " <span style='color:#286090;font-weight: bold;'>"+key+"</span> "
  //               }
  //               $(".art").append(to_be_replaced)
  //               article.replace(key, val)
  //             })

  //             console.log(obj)              

  //           },
  //           error: function(obj) {
  //             alert("error")
  //           },
  //           complete: function() {
  //               $('#loading_icon',".lds-css").hide();
  //               $('#loading_icon').hide();
  //             }
  //         })

  // }


    })

    $("#article_heading").on("keyup", function() {
      // alert("dddd")
      // if()
      article = $(this).val()
      console.log("=====xxxx")
      var lastChar = article[article.length -1];
      console.log(lastChar)
      console.log("=====yyy")

      // alert($(this).val())

  // if (lastChar == ".") {
  //     $.ajax({
  //           url: '{{ url("/readMediaBias") }}',
  //           headers:{
  //               'X-CSRF-TOKEN': "{{ csrf_token() }}"
  //           },
  //           method: 'GET',
  //           dataType: 'JSON',
  //           data:  {"article": article},
  //           beforeSend: function() {
  //               $('#loading_icon').show();
  //           },
  //           success: function(obj) {
  //             // alert("success")
  //             console.log("obj")
  //             console.log($.type(obj))
  //             console.log(obj)

  //             $(".article_h").empty()
  //             $.each(obj, function(key, val) {
  //               console.log(key)
  //               console.log(val)
  //               if(val == "Centre") {
  //                 to_be_replaced = " <span style='color:#c9302c; font-weight: bold;'>"+key+"</span> "
  //               }
  //               else if(val=="Left") {
  //                 to_be_replaced = " <span style='color:#4cae4c;font-weight: bold;'>"+key+"</span> "
  //               }
  //               else {
  //                 to_be_replaced = " <span style='color:#286090;font-weight: bold;'>"+key+"</span> "
  //               }
  //               $(".article_h").append(to_be_replaced)
  //               article.replace(key, val)
  //             })

  //             console.log(obj)              

  //           },
  //           error: function(obj) {
  //             alert("error")
  //           },
  //           complete: function() {
  //               $('#loading_icon',".lds-css").hide();
  //               $('#loading_icon').hide();
  //             }
  //         })

  // }

    })

// ==Change Bias type begins

$(document).on("change", ".change_bias", function() {

    id = $(this)[0].id
    // console.log("-===================")
    // console.log("article sentence")
    // console.log($("tr#"+id+" td:first-child").text())

    // console.log($("tr#"+id+" input.bias_type").val())
    // console.log("article heading")
    // console.log($("tr#"+id+" input.article_heading").val())
    // console.log("-===================")

    article_sentence = $("tr#"+id+" td:first-child").text()
    bias_type = $("tr#"+id+" input.bias_type").val()
    article_heading = $("tr#"+id+" input.article_heading").val()

    bias = $(this).val()
      $.ajax({
            url: '{{ url("/changeArticleBias") }}',
            headers:{
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            method: 'GET',
            dataType: 'JSON',
            data:  {"bias_type": bias,"article_heading": article_heading, "article_sentence": article_sentence},
            beforeSend: function() {
                $('#loading_icon').show();
            },
            success: function(obj) {

                swal({
                    title: "Saved!",
                    text: "Article Bias changed!",
                    icon: "success",
                });
            },
            error: function(obj) {

                swal({
                    title: "Server Error!",
                    text: "Internal Server error occured!",
                    icon: "warning",
                });

            },
            complete: function() {
                $('#loading_icon',".lds-css").hide();
                $('#loading_icon').hide();
              }
          })
    })
// ==Change Bias type ends

</script>
@stop
