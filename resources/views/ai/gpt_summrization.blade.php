@extends('layouts.app')

@section('title', 'Volv AI | GPT ')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Article Summarization</h3>
        </div>
        <div class="row" style="margin-top: 15px;">
            <form id="gpt_content_form" action="{{ url('/fetch_gpt_summarization') }}" method="POST">
                @csrf
              <div class="form-group">
                <label for="article_text">Article Text</label>
                <textarea placeholder="Enter your article here..." rows="6" class="form-control" id="article_text" name="article_text"></textarea>
              </div>
              <input type="submit" class="btn btn-success" value="Submit" />
            </form>
        </div>
        <br>
        <br>
        <div class="row">
                <div class="panel panel-default">
                  <div class="panel-heading">AI Generated Summary
                    <button onclick="copyToClipboard('#article_content')">
                        <i class="fa fa-copy"></i>
                    </button>
                  </div>
                  <div class="panel-body" id="article_content">N.A.</div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    $(function() {
    $("#gpt_content_form").on("submit", function(e) {
        e.preventDefault();
      article_text = $("#article_text").val();

      $.ajax({
        url: "{{ url('/fetch_gpt_summarization') }}",
        method: "POST",
        dataType: "JSON",
        headers:{
                 'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },   
        data: {"article_text": article_text},
          beforeSend: function() {
            $('#loading_icon').show();
          },
        success: function(obj) {
            console.log("obj")
            console.log(obj)
            if (obj.status == "success") {
                $("#article_content").text(obj.description)
                $(".panel").removeClass('panel-default')
                $(".panel").removeClass('panel-danger')
                $(".panel").addClass('panel-success')
            }
            if (obj.status == "failed") {
                $("#article_content").text(obj.description)
                $(".panel").removeClass('panel-default')
                $(".panel").removeClass('panel-success')
                $(".panel").addClass('panel-danger')
            }
        },
        error: function(obj) {
            if (obj.status == "failed") {
                $("#article_content").text(obj.description)
                $(".panel").removeClass('panel-default')
                $(".panel").addClass('panel-danger')
            }
            if (obj.status == "failed") {
                $("#article_content").text(obj.description)
                $(".panel").removeClass('panel-default')
                $(".panel").addClass('panel-danger')
            }
        },
        complete: function() {            
            $('#loading_icon').hide();
        }
      })
    })        
    })
    
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }

</script>
@endsection
