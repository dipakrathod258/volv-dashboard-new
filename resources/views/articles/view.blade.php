@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <h3><u>View Article:</u></h3>
    
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
    
    <form enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="col-sm-6">
          <div class="form-group">
            <label>Article Heading&nbsp;<span class="mandatory">*</span></label>
            <input type="text" class="form-control" id="article_heading" value="{{$article->article_heading}}" name="article_heading" value="{{$article->article_heading}}" readonly="readonly">
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
    <label for="pwd">Notification Text</label>
    <textarea name="notification_text" class="form-control" id="notification_text"  cols="50" rows="5" readonly="readonly">{{$article->notification_text}}</textarea>
    <small><em><b>Input Article Heading</b> Max Length : 20 Words.</em></small>
    <span  class="pull-right">Word count:&nbsp;<b><span id="notification_text_count">0&nbsp;&nbsp;</span></b></span>&nbsp;

    </div>


    <div class="form-group">
    <label>News Type:</label><br>
    @if($article->breaking_news == 1)
        <label class="radio-inline"><input type="radio" name="news" id="breaking_news" value="breaking_news" checked='checked' readonly="readonly">Breaking News</label>
    @else
    <label class="radio-inline"><input type="radio" name="news" id="breaking_news" value="breaking_news" readonly="readonly">Breaking News</label>
    @endif
    @if($article->trending_news == 1)
    <label class="radio-inline"><input type="radio" name="news" id="trending_news" value="trending_news" checked='checked' readonly="readonly">Trending News</label>
    @else
    <label class="radio-inline"><input type="radio" name="news" id="trending_news" value="trending_news" readonly="readonly">Trending News</label>
    @endif
    <a id="clear_btn" class="btn btn-primary" style="border-radius: 25px;">Clear</a>

</div>


          <div class="form-group">
            <label for="pwd">Article Bit&nbsp;<span class="mandatory">*</span></label>
            <textarea name="article_summary" id="article_summary" class="form-control" readonly="readonly" rows="5">{{$article->article_summary}}</textarea>
            <small><em><b>Input Article Summary</b> Max Length : 70 Words.</em></small>
            <span  class="pull-right">Character count:&nbsp;<b><span id="article_summary_char_count">0</span></b></span>            
            <span  class="pull-right">Word count:&nbsp;<b><span id="article_summary_count">0&nbsp;&nbsp;</span></b></span>
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
            <label for="sel1">Article Author</label>
            <input type="text" class="form-control" name="" value="{{$article->article_author}}" readonly="readonly">
          </div>
<!--           <div class="form-group">
            <label>Source of Article&nbsp;</label>
            <input type="text" class="form-control" name="article_source" value="{{$article->article_source}}">
            <small><em><b>Format Article Source must Valid Url,</b> Valid Url.</em></small>
          </div>
 -->

          <div class="form-group">
            <label>Main Source of Article&nbsp;<span class="mandatory">*</span></label>
            <input type="text" id="main_article_source" class="form-control" name="main_source" value="{{$article->main_source}}" readonly="readonly">
            <small><em><b>Format Article Source must Valid Url,</b> Valid Url.</em></small>
          </div>
          <div class="form-group">
            <label>Additional Source of Article&nbsp;</label>
            <input type="text" id="additional_article_source" class="form-control" name="additional_source" value="{{$article->additional_sources}}" readonly="readonly">
            <small><em><b>Format Article Source must Valid Url,</b> Valid Url.</em></small>
          </div>


            

      </div>
      <div class="col-sm-6">

      <div class="form-group">
            <label>Article Image&nbsp;<span class="mandatory">*</span></label>

            <img src="{{$article->article_image}}" width="250">
            
            <!-- <input type="file" class="form-control" name="article_image" value="{{$article->article_image}}"> -->
            <!-- <small><em><b>File extension must be</b> JPG,PNG, <b>Max dimension</b> 1920 X 1080, <b>Max file size</b> 1024 kb.</em></small> -->
          </div>

          <div class="form-group">
            <label>Article Image URL&nbsp;<span class="mandatory">*</span></label>
            <input type="text" class="form-control" value="{{$article->article_image}}" disabled="disabled">
            
            
            <!-- <input type="file" class="form-control" name="article_image" value="{{$article->article_image}}"> -->
            <!-- <small><em><b>File extension must be</b> JPG,PNG, <b>Max dimension</b> 1920 X 1080, <b>Max file size</b> 1024 kb.</em></small> -->
      </div>
      <div class="form-group">
            <label>Categories(#Hashtags)&nbsp;<span class="mandatory">*</span></label>
            <select class="form-control m-select2" id="article_category" name="article_category[]" multiple="multiple" disabled="disabled">
                <optgroup label="Events">
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
            <label>Sub-categories/#Mini-hashtags(Optinal)</label>
          <!--   <select class="form-control" name="article_category" multiple="multiple" id="article_category" disabled="disabled">
              <option value="Technology" selected="selected">Technology</option>
            </select> -->


            <select class="form-control m-select2" id="article_sub_category" name="article_category[]" multiple="multiple" disabled="disabled">
                <optgroup label="Events">
                    @foreach($article_subcategories as $article_sub_category)
                      @foreach($sub_categories as $sub_category)
                          @if($article_sub_category==$sub_category->sub_category)
                            <option value="{{$article_sub_category}}" selected="selected">#{{$article_sub_category}}</option>

                          @else
                            <option value="{{$category->category_title}}">#{{$category->category_title}}</option>
                          @endif
                        @endforeach
                    @endforeach
                </optgroup>
            </select>

            <small><em><b>Input Article Categories</b>&nbsp;Max Length : 250, Select Options: min=1 & max=4</em></small>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="">Read more text:</label>
                <input type="text" value="{{ $article->read_more_text }}" class="form-control" readonly>
              </div>
            </div>          
            <div class="col-sm-6">
              <div class="form-group">
                <label for="">Read more text color</label>
                <input type="color" class="form-control" value="#E77329">
                </div>
            </div>
          </div>






       
<!--           <div class="form-group">
            <label>Trending Categories</label>
            <select class="form-control" name="trending_category"  multiple = "multiple" id="trending_category" disabled="disabled">

                <option value="2020 elections" selected="selected">2020 elections</option>
            </select>
            <small><em><b>Input Article Trending Categories</b> Max Length : 250.</em></small>
          </div>
 -->
           <!-- <div class="form-group">
            <label>Enable ACT Now?&nbsp;</label>
            <label class="radio-inline"><input type="radio" name="act_now" checked>Yes</label>
            <label class="radio-inline"><input type="radio" name="act_now">No</label>
          </div> -->
          <div class="form-group">
            <label>Keywords</label>
            <textarea name="article_keywords" class="form-control" readonly="readonly">{{$article->article_keywords}}</textarea>
          </div>        

          <div class="form-group">
            <label>
              <img src="/assets/icons/united-states.svg" width="20" alt="USA Flag" title="United States of America">
            Targetting States</label>
            <i class="fas fa-flag-usa"></i>
            <select class="form-control m-select2" id="targetting_state" name="targetting_states" multiple="multiple" disabled="disabled">
                <optgroup label="Events">
                    @foreach($states as $state)
                        @foreach($targetting_states as $target_state)
                          @if($target_state==$state->state_name)
                            <option value="{{$target_state}}" selected="selected">{{$target_state}}</option>

                          @else
                            <option value="{{$target_state}}">{{$target_state}}</option>

                          @endif
                        @endforeach
                    @endforeach
                </optgroup>
            </select>
          </div> 

        @if(isset($article_bias))
          <div class="form-group">
            <label>Is this article bias?:</label><br>
            @if($article_bias->left_bias == 1)
                <label class="radio-inline"><input type="radio" name="news" id="breaking_news" value="breaking_news" checked='checked' readonly="readonly">Left</label>
            @else
            <label class="radio-inline"><input type="radio" name="news" id="breaking_news" value="breaking_news" readonly="readonly">Left</label>
            @endif
            @if($article_bias->right_bias == 1)
            <label class="radio-inline"><input type="radio" name="news" id="trending_news" value="trending_news" checked='checked' readonly="readonly">Right</label>
            @else
            <label class="radio-inline"><input type="radio" name="news" id="trending_news" value="trending_news" readonly="readonly">Right</label>
            @endif

            @if($article_bias->center_bias == 1)
            <label class="radio-inline"><input type="radio" name="news" id="trending_news" value="trending_news" checked='checked' readonly="readonly">Center</label>
            @else
            <label class="radio-inline"><input type="radio" name="news" id="trending_news" value="trending_news" readonly="readonly">Center</label>
            @endif

            <a id="clear_btn" class="btn btn-primary" style="border-radius: 25px;">Clear</a>

        </div>
        @endif

      </div>
    </div>
    <center>
      <!-- <button type="submit" class="btn btn-success">Submit</button> -->
    </center>
  </form>
</div>
<script type="text/javascript">
  $(function() {
    
    states="Alabama|Alaska|Arizona|Arkansas|California|Colorado|Connecticut|Delaware|District of Columbia|Florida|Georgia|Hawaii|Idaho|Illinois|Indiana|Iowa|Kansas|Kentucky|Louisiana|Maine|Maryland|Massachusetts|Michigan|Minnesota|Mississippi|Missouri|Montana|Nebraska|Nevada|New Hampshire|New Jersey|New Mexico|New York|North Carolina|North Dakota|Ohio|Oklahoma|Oregon|Pennsylvania|Rhode Island|South Carolina|South Dakota|Tennessee|Texas|Utah|Vermont|Virginia|Washington|West Virginia|Wisconsin|Wyoming";
    states_list = states.split("|")
    for (i=0;i<states_list.length;i++) {
      $("#targetting_state").append("<option value="+states_list[i]+">"+states_list[i]+"</option>")
    }
    $("#article_category, #trending_category, #targetting_state, #article_sub_category").select2();
    // $("#article_summary").summernote()

    var input = document.getElementById("article_heading");

    input.addEventListener("keypress", function(evt){

      var words = this.value.split(/\s+/);
      var numWords = words.length;
      var maxWords = 12;
      if(numWords > maxWords){
        $("#alert_message").show()
        $(".message").html("Article Heading length exceeded.")
        $("#alert_message").css("transition","1s")
        evt.preventDefault();
      }
    });
    
    var input1 = document.getElementById("article_summary");

    input1.addEventListener("input", function(evt){
      alert('o')
      var words = this.value.split(/\s+/);
      var numWords = words.length;
      var maxWords = 70;
      if(numWords > maxWords){
        $("#alert_message").show()
        $(".message").html("Article Summary length exceeded.")
        $("#alert_message").css("transition","1s")
        evt.preventDefault();
      }
    });







// Edit Article auto suggest Bias begins
    article1 = $("#article_heading").val()
    console.log("article")

      $.ajax({
            url: '{{ url("/readMediaBias") }}',
            headers:{
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            method: 'GET',
            dataType: 'JSON',
            data:  {"article": article1},
            beforeSend: function() {
                $('#loading_icon').show();
            },
            success: function(obj) {
              // alert("success")
              console.log("obj")
              console.log($.type(obj))
              console.log(obj)

              $(".art").empty()
              $.each(obj, function(key, val) {
                console.log(key)
                console.log(val)
                if(val == "Centre") {
                  to_be_replaced = " <span style='color:#c9302c;font-weight: bold;'>"+key+"</span> "
                }
                else if(val=="Left") {
                  to_be_replaced = " <span style='color:#4cae4c;font-weight: bold;'>"+key+"</span> "
                }
                else {
                  to_be_replaced = " <span style='color:#286090;font-weight: bold;'>"+key+"</span> "
                }
                $(".article_h").append(to_be_replaced)
                article.replace(key, val)
              })

              console.log(obj)              

            },
            error: function(obj) {
              //alert("error")
            },
            complete: function() {
                $('#loading_icon',".lds-css").hide();
                $('#loading_icon').hide();
              }
          })


    article = $("#article_summary").val()

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
              console.log("this is article summary")
              console.log($.type(obj))

              $(".art").empty()
              $.each(obj, function(key, val) {
                console.log(key)
                console.log(val)
                if(val == "Centre") {
                  to_be_replaced = " <span style='color:#c9302c;font-weight: bold;'>"+key+"</span> "
                }
                else if(val=="Left") {
                  to_be_replaced = " <span style='color:#4cae4c;font-weight: bold;'>"+key+"</span> "
                }
                else {
                  to_be_replaced = " <span style='color:#286090;font-weight: bold;'>"+key+"</span> "
                }
                $(".art").append(to_be_replaced)
                article.replace(key, val)
              })

              console.log(obj)              

            },
            error: function(obj) {
             // alert("error")
            },
            complete: function() {
                $('#loading_icon',".lds-css").hide();
                $('#loading_icon').hide();
              }
          })

// Edit Article auto suggest Bias ends


  })  
</script>
@endsection
