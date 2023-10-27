@extends('layouts.app')
@section('title','Edit Article')
@section('edit_article_internal_css')

<style type="text/css">
  .mandatory {
    color: #f00;
  }
  small {
    color: #808080;
  }
  #alert_message {
    display: none;
  }
  #loading_icon, .article_heading_char_count_error, .article_summary_char_count_error, .heading_length_errors,.summary_length_errors, .main_source_errors, .additional_source_errors, .success_msg, .article_exists_error, .alert_summary_error_message, .message, .summary_length_errors_min, .heading_length_errors_min, .notification_text_error_min {
    display: none;
  }

  .main_section {
    width: 1373px;
  }

  #article_table .btn-primary {
    background-color: #FF7F50 !important;
    border-color: #FF7F50 !important;
  }
    
    #nav-color-change  {
      background-color: #337AB7;
      border:none;
      padding-bottom: 30px;
    }

    #button-color-change{
      background-color:#E8582B;
      border:none;
    }
  
  .btn-edited, .btn-edited:hover, .btn-edited:focus {
    color: #fff;
    background-color: #a91b47;
  }
  .success_msg, .article_exists_error, #notificatin_text_error, #news_type_error {
    display: none;
  }
  

</style>
@endsection

@section("content")
<!-- <div id="loading_icon" style="display: none;">

</div> -->

<div class="container">
  <div class="row">
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
        <strong>Congratulations!&nbsp;</strong>your article updated successfully.
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
        <li class="alert alert-danger heading_length_errors_min"><strong>Wait!</strong> Article Heading length is less than 5 words.</li>
      </ul>

      
      <ul style="list-style-type: none;">
        <li class="alert alert-danger summary_length_errors"><strong>Wait!</strong> Article Summary length exceeded to more than 70 words.</li>
      </ul>

      <ul style="list-style-type: none;">
        <li class="alert alert-danger summary_length_errors_min"><strong>Wait!</strong> Article Summary length is less than 60 words.</li>
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
        <li class="alert alert-warning svg_image_error"><span><b>Wait!</b>&nbsp;SVG article image URL is not allowed.</span></li>
      </ul> 

      <ul style="list-style-type: none;">
        <li class="alert alert-warning encoded_image_error"><span><b>Wait!</b>&nbsp;Encoded article image URL is not allowed. Eg. "data://image/jpeg......"</span></li>
      </ul>      

<!-- ===Article create Errors message ends===-->    
  </div>
  <div class="row">
    <h4>
      <img src="{{ url('/assets/imgs/create_article.png') }}" alt="Create Article Image" title="Create an Article" width="30">
    <b>Edit Articles</b></h4>
    <div id="alert_message" class="alert alert-danger alert-dismissible" role="alert">
      <strong>Wait!</strong> <span class="message"></span>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    
    @if(isset($create_article_validation_flag))
      @foreach($validation_error_list as $error)
        <div id="alert_message" class="alert alert-danger alert-dismissible" role="alert">
          <strong>Wait!</strong> <span class="message">{{$error}}</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

      @endforeach
    @endif
    
    <form id="update_article" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="col-sm-6">

          <div class="form-group">
            <label>Article Heading&nbsp;<span class="mandatory">*</span></label>
            <input type="text" class="form-control" id="article_heading" value="{{$article->article_heading}}" name="article_heading" value="{{$article->article_heading}}">
            <small><em><b>Input Article Heading</b> Max Length : 12 Words.</em></small>
            <span  class="pull-right">Character count:&nbsp;<b><span id="article_heading_character_count"></span></b></span>
            <span  class="pull-right">Word count:&nbsp;<b><span id="article_heading_count">&nbsp;&nbsp;</span></b></span>&nbsp;
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
            <label for="pwd">Notification Text</label>
            <textarea name="notification_text" class="form-control" id="notification_text"  cols="50" rows="5">{{$article->notification_text}}</textarea>
            <small><em><b>Input Article Heading</b> Max Length : 25 Words.</em></small>
            <span  class="pull-right">Word count:&nbsp;<b><span id="notification_text_count">0&nbsp;&nbsp;</span></b></span>&nbsp;

          </div>


          <div class="form-group">
            <label>News Type:</label><br>
            @if($article->breaking_news == 1)
              <label class="radio-inline"><input type="radio" name="news" id="breaking_news" value="breaking_news" checked='checked'>Breaking News</label>
            @else
            <label class="radio-inline"><input type="radio" name="news" id="breaking_news" value="breaking_news">Breaking News</label>
            @endif
            @if($article->trending_news == 1)
            <label class="radio-inline"><input type="radio" name="news" id="trending_news" value="trending_news" checked='checked'>Trending News</label>
            @else
            <label class="radio-inline"><input type="radio" name="news" id="trending_news" value="trending_news">Trending News</label>
            @endif
            <a id="clear_btn" class="btn btn-primary" style="border-radius: 25px;">Clear</a>

          </div>


          <div class="form-group">
            <label for="pwd">Article Bit&nbsp;<span class="mandatory">*</span></label>
            <textarea name="article_summary" id="article_summary" class="form-control"  cols="50" rows="5">{{$article->article_summary}}</textarea>
            <small><em><b>Input Article Summary</b> Max Length : 70 Words.</em></small>
            <span  class="pull-right">Character count:&nbsp;<b><span id="article_summary_char_count"></span></b></span>            
            <span  class="pull-right">Word count:&nbsp;<b><span id="article_summary_count">&nbsp;&nbsp;</span></b></span>
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
            <input type="hidden" class="form-control" name="article_author" value="{{$article_author}}  " readonly="readonly">
          </div>

          <div class="form-group">
            <label>Main Source of Article&nbsp;<span class="mandatory">*</span></label>
            <input type="text" id="main_article_source" class="form-control" name="main_source" value="{{$article->main_source}}">
            <small><em><b>Format Article Source must Valid Url,</b> Valid Url.</em></small>
        </div>

        <div class="form-group">
              <label>Is main source article bias?:</label><br>
              @if($article->article_bias == "left")
                <label class="radio-inline"><input type="radio" name="bias" id="left_bias" value="left" checked='checked'>Left</label>
              @else
              <label class="radio-inline"><input type="radio" name="bias" id="left_bias" value="left">Left</label>
              @endif

              @if($article->article_bias == "right")
              <label class="radio-inline"><input type="radio" name="bias" id="right_bias" value="right" checked='checked'>Right</label>
              @else
              <label class="radio-inline"><input type="radio" name="bias" id="right_bias" value="right">Right</label>
              @endif

              @if($article->article_bias == "center")
              <label class="radio-inline"><input type="radio" name="bias" id="center_bias" value="center" checked='checked'>Center</label>
              @else
              <label class="radio-inline"><input type="radio" name="bias" id="center_bias" value="center">Center</label>
              @endif


              <a id="clear_btn" class="btn btn-primary" style="border-radius: 25px;">Clear</a>

            </div>


            <div class="form-group">
            <label>Additional Source of Article&nbsp;</label>
            <input type="text" id="additional_article_source" class="form-control" name="additional_source" value="{{$article->additional_sources}}">
            <small><em><b>Format Article Source must Valid Url,</b> Valid Url.</em></small>
          </div>


            <!-- <div class="form-group">
              <label>Is embedded link?:</label><br>
              @if($article->is_embed_link == "Yes")
                <label class="radio-inline"><input type="radio" name="embedded" id="embedded_yes" value="Yes" checked='checked'>Yes</label>
              @else
              <label class="radio-inline"><input type="radio" name="embedded" id="embedded_yes" value="Yes">Yes</label>
              @endif

              @if($article->is_embed_link == "No")
              <label class="radio-inline"><input type="radio" name="embedded" id="embedded_no" value="No" checked='checked'>No</label>
              @else
              <label class="radio-inline"><input type="radio" name="embedded" id="embedded_no" value="No">No</label>
              @endif

              <a id="clear_btn" class="btn btn-primary" style="border-radius: 25px;">Clear</a>

            </div> -->

      </div>
      <div class="col-sm-6">

          <div class="form-group">
              <label>Is additional source article bias?:</label><br>
              @if($article->additional_source_bias == "left")
                <label class="radio-inline"><input type="radio" name="additional_bias" id="add_left_bias" value="left" checked='checked'>Left</label>
              @else
              <label class="radio-inline"><input type="radio" name="additional_bias" id="add_left_bias" value="left">Left</label>
              @endif

              @if($article->additional_source_bias == "right")
              <label class="radio-inline"><input type="radio" name="additional_bias" id="add_right_bias" value="right" checked='checked'>Right</label>
              @else
              <label class="radio-inline"><input type="radio" name="additional_bias" id="add_right_bias" value="right">Right</label>
              @endif

              @if($article->additional_source_bias == "center")
              <label class="radio-inline"><input type="radio" name="additional_bias" id="add_center_bias" value="center" checked='checked'>Center</label>
              @else
              <label class="radio-inline"><input type="radio" name="additional_bias" id="add_center_bias" value="center">Center</label>
              @endif


              <a id="clear_btn" class="btn btn-primary" style="border-radius: 25px;">Clear</a>

            </div>


            <div class="form-group">
              <label>Is this article republishable?:</label><br>
              @if(isset($republishable_article_flag))
                <label class="radio-inline">
                  <input type="radio" name="republishable" id="republishable" value="republishable" checked='checked'>Republishable</label>
              @else
              <label class="radio-inline"><input type="radio" name="republishable" id="republishable" value="republishable">republishable</label>
              @endif

              <a id="republishable_clear_btn" class="btn btn-primary" style="border-radius: 25px;">Clear</a>

            </div>


          <div class="row">
            <div class="col-sm-4">

              <div class="form-group">
                <!-- <label>Article Image&nbsp;<span class="mandatory">*</span></label> -->

                <img src="{{$article->article_image}}" width="150">
              </div>

            </div>          

            <div class="col-sm-8">
              <div class="form-group">
                <label>Article Image URL</label>

                <input type="url" class="form-control" name="article_image_url" value="{{ $article->article_image }}">            
              </div>
            </div>

          </div>


          <div class="row">
            @if(isset($article->article_video_url))
            <div class="col-sm-12">

              <div class="form-group">

                    <video
                      id="my-video"
                      class="video-js"
                      controls
                      preload="auto"
                      width="400"
                      height="200"
                      data-setup="{}"
                    >
                      <source src="{{$article->article_video_url}}" />
                      <!-- <source src="MY_VIDEO.webm" type="video/webm" /> -->
                      <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a
                        web browser that
                        <a href="https://videojs.com/html5-video-support/" target="_blank"
                          >supports HTML5 video</a
                        >
                      </p>
                    </video>
              </div>
            </div>          
            @endif
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Article Video URL</label>

                <input type="url" class="form-control" name="article_video_link" value="{{ $article->article_video_url }}">            
              </div>              
            </div>
          </div>




          <div class="form-group">
            <label>Categories (#Hashtags)&nbsp;<span class="mandatory">*</span></label>
            <select class="form-control m-select2" id="article_category" name="article_category[]" multiple="multiple">
                <optgroup label="Events">
<!--                     @foreach($categories as $category)
                          @if(in_array($category->category_title, $article_categories))
                            <option value="{{$category->category_title}}" selected="selected">#{{$category->category_title}}</option>
                          @else
                            <option value="{{$category->category_title}}">#{{$category->category_title}}</option>
                          @endif
                      @endforeach -->
                    @foreach($article_categories as $article_category)
                      @foreach($categories as $category)
                          @if($article_category==$category->category_title)
                            <option value="{{$article_category}}" selected="selected">#{{$article_category}}</option>

                          @else
                            <option value="{{$category->category_title}}">#{{$category->category_title}}</option>
                          @endif
                        @endforeach
                    @endforeach
                </optgroup>
            </select>
          </div> 


          <div class="form-group">
            <label>Sub-categories/ #Mini-hashtags(Optional)</label>
            <select class="form-control m-select2" id="sub_category" name="article_sub_category[]" multiple="multiple">
                <optgroup label="Events">
                    @foreach($minihashtags as $minihashtag)
                          @if(in_array($minihashtag->sub_category, $article_subcategories))
                            <option value="{{$minihashtag->sub_category}}" selected="selected">#{{$minihashtag->sub_category}}</option>
                          @else
                            <option value="{{$minihashtag->sub_category}}">#{{$minihashtag->sub_category}}</option>
                          @endif
                      @endforeach
                </optgroup>
            </select>
          </div> 


          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
              <label>Read More text&nbsp;<span class="mandatory">*</span></label>
              <select class="form-control m-select2" id="read_more_text" name="read_more_text">
                  @foreach($readMoreTextArray as $read_more)
                        @if(in_array($read_more, $readMoreArray))
                          <option value="{{$read_more}}" selected="selected">{{$read_more}}</option>
                        @else
                          <option value="{{$read_more}}">{{$read_more}}</option>
                        @endif
                    @endforeach
              </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label>Read more text color&nbsp;(Default)</label>
                <input type="color" name="read_more_text_color" class="form-control" value="#E77329">
              </div>  
            </div>

          </div>


            <!-- <div class="form-group">
              <label>Is this article bias?:</label><br>
              @if($article->article_bias == "left")
                <label class="radio-inline"><input type="radio" name="bias" id="left_bias" value="left" checked='checked'>Left</label>
              @else
              <label class="radio-inline"><input type="radio" name="bias" id="left_bias" value="left">Left</label>
              @endif

              @if($article->article_bias == "right")
              <label class="radio-inline"><input type="radio" name="bias" id="right_bias" value="right" checked='checked'>Right</label>
              @else
              <label class="radio-inline"><input type="radio" name="bias" id="right_bias" value="right">Right</label>
              @endif

              @if($article->article_bias == "center")
              <label class="radio-inline"><input type="radio" name="bias" id="center_bias" value="center" checked='checked'>Center</label>
              @else
              <label class="radio-inline"><input type="radio" name="bias" id="center_bias" value="center">Center</label>
              @endif


              <a id="clear_btn" class="btn btn-primary" style="border-radius: 25px;">Clear</a>

            </div> -->
            
          <div class="form-group">
            <label>Enable ACT Now?&nbsp;</label>
            <label class="radio-inline"><input type="radio" name="act_now" checked>Yes</label>
            <label class="radio-inline"><input type="radio" name="act_now">No</label>
          </div>
          <div class="form-group">
            <label>Keywords</label>
            <textarea name="article_keywords" class="form-control">{{$article->article_keywords}}</textarea>
          </div>        
          <div class="form-group">
            <label>
              <img src="/assets/icons/united-states.svg" width="20" alt="USA Flag" title="United States of America">
            Targetting States</label>
            <i class="fas fa-flag-usa"></i>


            <select class="form-control m-select2" id="targetting_state" name="targetting_states[]" multiple="multiple">
                <optgroup label="Events">
                    @foreach($targetting_states as $targetting_state)
                        @foreach($states as $state)
                          @if($targetting_state==$state->state_name)
                            <option value="{{$targetting_state}}" selected="selected">{{$targetting_state}}</option>
                          @else
                            <option value="{{$state->state_name}}">{{$state->state_name}}</option>

                          @endif
                        @endforeach
                    @endforeach
                </optgroup>
            </select>
          </div> 

      </div>
    </div>
    <center>
      <!-- <button type="button" class="btn btn-info" id="save_article_to_in_progress_btn">Save for later</button> -->
      <button type="submit" class="btn btn-info">Save for later</button>
      <button type="submit" class="btn btn-success">Submit</button>
    </center>
  </form>
</div>

<div id="check_bias_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width: 1600px;">

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
    $(".article_video_link_invalid_msg").hide()
    
  @if(isset($article_heading_max_word_error_flag))
    $(".heading_length_errors").show()
  @endif

  @if(isset($article_heading_max_char_error_flag))
    $(".article_heading_char_count_error").show()
  @endif

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".errors").hide()
    states="Alabama|Alaska|Arizona|Arkansas|California|Colorado|Connecticut|Delaware|District of Columbia|Florida|Georgia|Hawaii|Idaho|Illinois|Indiana|Iowa|Kansas|Kentucky|Louisiana|Maine|Maryland|Massachusetts|Michigan|Minnesota|Mississippi|Missouri|Montana|Nebraska|Nevada|New Hampshire|New Jersey|New Mexico|New York|North Carolina|North Dakota|Ohio|Oklahoma|Oregon|Pennsylvania|Rhode Island|South Carolina|South Dakota|Tennessee|Texas|Utah|Vermont|Virginia|Washington|West Virginia|Wisconsin|Wyoming";
    states_list = states.split("|")


var words = $('#article_heading').val().split(/ [A-Z|a-z|0-9|(|)]+/);
      // console.log(words)
var numWords = words.length;
// $("#article_heading_count").html(numWords)
article_heading_char_count = $("#article_heading").val().length
$("#article_heading_character_count").html(article_heading_char_count)

var words = $("#article_summary").val().split(/\s+/);
var numWords = words.length;
$("#article_summary_count").html(numWords)
// alert(numWords)
article_summary_char_count = $("#article_summary").val().length
console.log(article_summary_char_count)
$("#article_summary_char_count").html(article_summary_char_count)



// alert(numWords)
article_summary_char_count = $("#article_summary").val().length
console.log(article_summary_char_count)
$("#article_summary_char_count").html(article_summary_char_count)

var words = $('#notification_text').val().split(/ [A-Z|a-z|0-9|(|)]+/);
      // console.log(words)
var numWords = words.length;
$("#notification_text_count").html(numWords)
    for (i=0;i<states_list.length;i++) {
      $("#targetting_state").append("<option value="+states_list[i]+">"+states_list[i]+"</option>")
    }
    $("#article_category, #trending_category, #targetting_state, #sub_category").select2({
      tags: true
    });
    // $("#article_summary").summernote()

    $("#article_category, #trending_category, #targetting_state, #sub_category").on("select2:select", function (evt) {
      var element = evt.params.data.element;
      var $element = $(element);
      
      $element.detach();
      $(this).append($element);
      $(this).trigger("change");
    });



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
      var words = $('#article_heading').val().split(/ [A-Z|a-z|0-9|(|)]+/);
      // console.log(words)
      var numWords = words.length;
      $("#article_heading_count").html(numWords)
      // console.log(numWords)
       article_heading_char_count = $("#article_heading").val().length
       console.log("article_heading_char_count")
       console.log(article_heading_char_count)
      $("#article_heading_character_count").html(article_heading_char_count)

       
       if (article_heading_char_count > 70) {

        $(".article_heading_char_count_error").show();
       }
       else {
        $(".article_heading_char_count_error").hide();
       }
      //  else if (article_heading_char_count < 65) {        
      //     $(".article_heading_char_count_error").hide();
      //  }

      // var maxWords = 12;
      // if(numWords > maxWords) {
      //   $(".heading_length_errors").show()

      //   $("#alert_message").css("transition","1s")
      //   evt.preventDefault();
      // }
      // else if (numWords<=12) {
      //   $(".message, .heading_length_errors").hide()
      // }
    });

    var input = document.getElementById("article_summary");
    
    $(".alert_summary_error_message").hide()
    input.addEventListener("input", function(evt) {
      var words = $('#article_summary').val().split(/\s+/);
      var numWords = words.length;
      $("#article_summary_count").html(numWords)
      // alert(numWords)
      article_summary_char_count = $("#article_summary").val().length
      console.log(article_summary_char_count)
      $("#article_summary_char_count").html(article_summary_char_count)

      if (article_summary_char_count > 465) {
        $(".article_summary_char_count_error").show();
      }
      else if (article_summary_char_count <= 465) {
        $(".article_summary_char_count_error").hide();
      }


      // var maxWords = 70;
      // if(numWords > maxWords) {
      //   $(".summary_length_errors").show()
      // }
      // else if (numWords<=maxWords) {
      //   $(".summary_length_errors").hide()
      // }
    });



// ======Notification text show no of words real time begins===

var input = document.getElementById("notification_text");

$(".notification_text_error_message").hide()
input.addEventListener("input", function(evt) {
  var words = this.value.split(/ [A-Z|a-z|0-9|(|)]+/);
  var numWords = words.length;
  $("#notification_text_count").html(numWords)

  var maxWords = 30;
  // alert(numWords)
  if(numWords > maxWords) {
    $(".notification_text_error_min").show()
  }
  else if (numWords<=30) {
    $(".notification_text_error_min").hide()
  }
});


// ======Notification text show no of words real time begins===


    $(".campaign_flag").hide()
    $("#act_now_yes").click(function(){
        $(".campaign_flag").show()
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

    function articleHeadCount(article_heading) {
      var words = $('#article_heading').val().split(/ [A-Z|a-z|0-9|(|)]+/);

      var numWords = words.length;
      if (numWords> 12) {
        return true
      }
      else {        
        return false
      }

    }

// ===News Type clear logic begins

$("#clear_btn").on("click", function() {
      alert("ok")
      $("#breaking_news, #trending_news").prop('checked', false);
})

$("#republishable_clear_btn").on("click", function() {
      $("#republishable").prop('checked', false);
})

// ===News Type clear logic ends


// =======Creating an article through AJAX starts
        $('#update_article').on('submit', function(e) {
            e.preventDefault();

          error_counter = 0

// ======Article News type & notification text mandate validation begins 
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





// ======Article Heading error handling begins===

          var words = $('#article_heading').val().split(/ [A-Z|a-z|0-9|(|)]+/);
          var numWords = words.length;
           article_heading_char_count = $("#article_heading").val().length
           
           if (article_heading_char_count > 70) {
              error_counter=error_counter+1
              $(".article_heading_char_count_error").show();
              // alert("anda")
           }
           else if (article_heading_char_count < 65) {        
              $(".article_heading_char_count_error").hide();
           }

          // if(numWords > 12) {
          //   error_counter= error_counter+1
          //   $(".heading_length_errors").show()
          // }

          // else if(numWords==12) {
          //   $(".heading_length_errors, .heading_length_errors_min").hide()

          // }

// ======Article Heading error handling ends===

// ======Article Summary error handling begings===
          var words = $('#article_summary').val().split(/\s+/);
          var numWords = words.length;
          console.log("numwords")
          console.log(numWords)

          article_summary_char_count = $("#article_summary").val().length
          if (article_summary_char_count > 465) {
            $(".article_summary_char_count_error").show();
            error_counter=error_counter+1
          }
          else if (article_summary_char_count <= 465) {
            $(".article_summary_char_count_error").hide();
          }

          // var maxWords = 70;
          // if(numWords > maxWords) {
          //   $(".summary_length_errors_min").hide()
          //   $(".summary_length_errors").show()
          //   error_counter=error_counter+1
          // }
          // else if (numWords<=60) {
          //   $(".summary_length_errors").hide()
          //   $(".summary_length_errors_min").show()
          //   error_counter=error_counter+1
          // }
          // else if (numWords==maxWords) {
          //   $(".summary_length_errors, .summary_length_errors_min").hide()
          // }

// ======Article Summary error handling ends===

// ======Main Source URL format error handling begins===

          additional_article_source = $("#additional_article_source").val()
          main_article_source = $("#main_article_source").val()

          $(".main_source_errors").hide()            

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

// ======Main Source URL format error handling ends===

          if(error_counter==0) {
            // alert("Succes")
            $.ajax({
              url: '{{url("/update_articles")}}/{{$article->id}}',
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
                $(".lds-css").show()
              },
              success: function(obj) {
                // console.log(obj);
                // $(".alert-danger").remove();
                count=0;
                for(i=0;i<obj.length;i++) {
                  if(obj[i]!='') {
                    count++;
                  }
                }
                // console.log(count)
                  if (obj.status == "success") {
                    $(".article_exists_error, .alert-danger, .svg_image_error, .encoded_image_error").hide()
                    $(".success_msg").show()
                    setTimeout(()=>{
                      window.location = "{{url('/allDashboard')}}";
                    },3000);

                  }

                  if (obj.status == "article video link invalid") {
                    $(".article_exists_error, .alert-danger, .svg_image_error").hide()
                    $(".article_video_link_invalid_msg").show()
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
                console.log("In error")
                console.log(obj)
                console.log(obj.responseJSON.errors)

                  $('.errors').show()
                  $(".errors").empty()
                $.each(obj.responseJSON.errors, function(key, val) {
                  // alert("ok")
                  $('.errors').append("<li class='alert alert-danger'>"+val+"</li>")
                });




                  if (obj.status == "Article image URL is of SVG image") {
                    $(".success_msg, .alert-danger, .article_exists_error").hide();
                    $(".svg_image_error").show()
                  }

                  if (obj.status == "Encoded Article Image URL no allowed. Eg, 'data://image/jpeg......'") {
                    $(".success_msg, .alert-danger, .article_exists_error, .svg_image_error").hide();
                    $(".encoded_image_error").show()
                  }

              },
              complete: function() {
                $('#loading_icon',".lds-css").hide();
              }
            })
          }

        })

        $("#save_article_to_in_progress_btn").on("click", function() {
            $.ajax({
              url: '{{url("/update_articles_status_in_progress")}}/{{$article->id}}',
              headers:{
                 'X-CSRF-TOKEN': "{{ csrf_token() }}"
               },   
              method: 'get',
              type: 'JSON',
              // data:  new FormData(this),
              contentType: false,
              cache: false,
              processData:false,
              beforeSend: function() {
                $('#loading_icon').show();
                $(".lds-css").show()
              },
              success: function(obj) {
                // console.log(obj);
                // $(".alert-danger").remove();
                count=0;
                for(i=0;i<obj.length;i++) {
                  if(obj[i]!='') {
                    count++;
                  }
                }
                
                // console.log(count)
                  if (obj.status == "success") {
                    $(".article_exists_error, .alert-danger").hide()
                    $(".success_msg").show()
                    setTimeout(()=>{
                      window.location = "{{url('/')}}";
                    },3000);

                  }

              },
              error: function(obj) {
                $(".success_msg").hide();
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
              }
            })          
        })

// =======Creating an article through AJAX ends

// ========Check Bias API call to ML model starts

$("#check_bias_btn").on("click", function() {
      // alert("dddd")
      article = $("#article_summary").val()
      article_heading = $("#article_heading").val()
      

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

            //   $.each(obj, function(key, val) {
            //     console.log(key)
            //     console.log(val)
                // if(val == "Right") {
                //   $("#check_bias_modal table tbody").append("<tr style='color: #C9302C'><td>"+key+"</td><td>"+val+"</td></tr>")
                // }
                // else if(val == "Left") {
                //   $("#check_bias_modal table tbody").append("<tr style='color: #449D44'><td>"+key+"</td><td>"+val+"</td></tr>")
                // }
                // else if(val == "Centre") {
                //   $("#check_bias_modal table tbody").append("<tr style='color: #138496'><td>"+key+"</td><td>"+val+"</td></tr>")
                // }
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

                $("#check_bias_modal").modal()
            //   });

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



      // article = $("#article_summary").val()
      // article_heading = $("#article_heading").val()
      // console.log("article_heading")
      // console.log(article_heading)

    })


// Edit Article auto suggest Bias begins
    // article1 = $("#article_heading").val()
    // console.log("article")

    //   $.ajax({
    //         url: '{{ url("/readMediaBias") }}',
    //         headers:{
    //             'X-CSRF-TOKEN': "{{ csrf_token() }}"
    //         },
    //         method: 'GET',
    //         dataType: 'JSON',
    //         data:  {"article": article1},
    //         beforeSend: function() {
    //             $('#loading_icon').show();
    //         },
    //         success: function(obj) {
    //           // alert("success")
    //           console.log("obj")
    //           console.log($.type(obj))
    //           console.log(obj)

    //           $(".art").empty()
    //           $.each(obj, function(key, val) {
    //             console.log(key)
    //             console.log(val)
    //             if(val == "Centre") {
    //               to_be_replaced = " <span style='color:#c9302c;font-weight: bold;'>"+key+"</span> "
    //             }
    //             else if(val=="Left") {
    //               to_be_replaced = " <span style='color:#4cae4c;font-weight: bold;'>"+key+"</span> "
    //             }
    //             else {
    //               to_be_replaced = " <span style='color:#286090;font-weight: bold;'>"+key+"</span> "
    //             }
    //             $(".article_h").append(to_be_replaced)
    //             article.replace(key, val)
    //           })

    //           console.log(obj)              

    //         },
    //         error: function(obj) {
    //           alert("error")
    //         },
    //         complete: function() {
    //             $('#loading_icon',".lds-css").hide();
    //             $('#loading_icon').hide();
    //           }
    //       })


    // article = $("#article_summary").val()

    //   $.ajax({
    //         url: '{{ url("/readMediaBias") }}',
    //         headers:{
    //             'X-CSRF-TOKEN': "{{ csrf_token() }}"
    //         },
    //         method: 'GET',
    //         dataType: 'JSON',
    //         data:  {"article": article},
    //         beforeSend: function() {
    //             $('#loading_icon').show();
    //         },
    //         success: function(obj) {
    //           // alert("success")
    //           console.log("this is article summary")
    //           console.log($.type(obj))

    //           $(".art").empty()
    //           $.each(obj, function(key, val) {
    //             console.log(key)
    //             console.log(val)
    //             if(val == "Centre") {
    //               to_be_replaced = " <span style='color:#c9302c;font-weight: bold;'>"+key+"</span> "
    //             }
    //             else if(val=="Left") {
    //               to_be_replaced = " <span style='color:#4cae4c;font-weight: bold;'>"+key+"</span> "
    //             }
    //             else {
    //               to_be_replaced = " <span style='color:#286090;font-weight: bold;'>"+key+"</span> "
    //             }
    //             $(".art").append(to_be_replaced)
    //             article.replace(key, val)
    //           })

    //           console.log(obj)              

    //         },
    //         error: function(obj) {
    //           alert("error")
    //         },
    //         complete: function() {
    //             $('#loading_icon',".lds-css").hide();
    //             $('#loading_icon').hide();
    //           }
    //       })

// Edit Article auto suggest Bias ends








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

  $(function() {
        $('#video-to-play').trigger('play');
  })

  })  
</script>
@endsection