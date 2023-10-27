@extends('layouts.app')
@section('title', 'Summarizer')
@section('content')

<div class="container">
  <div class="row form-group shadow-textarea">
      <form action="/article_submit/" method="POST">
          <div class="col-sm-offset-1 col-sm-10 md-form amber-textarea active-amber-textarea">
              <label><i class="fa fa-file-text"></i>&nbsp;Text to be Summarized:</label>
              <textarea class="form-control z-depth-1" style="border-radius: 5px" name="article" rows="17" placeholder="Enter the article to be summarized..."></textarea>
          </div>
      </div>
      <div class="row">
          <div class="col-sm-offset-1 col-sm-6 col-xs-6">
              <a href="#" class="btn btn-danger"><i class="fa fa-trash"></i></a>                            
          </div>
          <div class="col-xs-6 col-sm-4" style="text-align: right;">
                  <span class="wordcount" style="text-align: right;">Word Count:<b id="summary-word-length">150</b></span>
          </div>                
      </div>
      <div class="row">
          <div class="col-sm-offset-1 col-sm-4" style="margin-top:25px; margin-bottom: 25px;">
              <label>Select the number of sentences for the summary:</label>
          </div>
          <div class="col-sm-4" style="margin-top:25px; margin-bottom: 25px;">
              <ul class="list-inline">
                  <li><span class="value-button" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</span></li>
                  <li><input type="number" id="number" value="0" /></li>
                  <li><span class="value-button" id="increase" onclick="increaseValue()" value="Increase Value">+</span></li>        
              </ul>    
          </div>
          <div class="col-sm-2" style="text-align: right; margin-top:25px; margin-bottom: 25px;">
              <button type="button" class="btn btn-success">Summarize</button>
          </div>
      </div>
    </form>
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10 keyword_section" style=" padding: 1%;
        border: 2px solid #ccc;
        border-radius: 5px;
        margin-top: 10px;
        margin-bottom: 10px;">
            <label>Keywords:</label><br>
            <span class="chip">google</span>
            <span class="chip">reviews</span>
            <span class="chip">dragonfly</span>
            <span class="chip">searches</span>
            <span class="chip">employees</span>
            <span class="chip">plans</span>
            <span class="chip">international</span>
        
        </div>
    </div>
    <div class="row">
      <div class="col-sm-offset-1 col-sm-5 col-xs-12" style="margin-top:20px;">
          <label><i class="fa fa-angle-double-right"></i>&nbsp;Rough Summary:</label>
          <textarea class="form-control z-depth-1" style="border-radius: 5px" rows="17" placeholder="Summary of text..."></textarea>
          <h4 class="wordcount">Word Count:<b id="summary-word-length">50</b></h4>  
      </div>
      <div class="col-sm-5 md-form amber-textarea active-amber-textarea; " style="margin-top: 20px;">
          <label><i class="fa fa-pencil-square-o"></i>&nbsp;Final Summary:</label>
          <textarea class="form-control z-depth-1" style="border-radius: 5px" rows="17" placeholder="Edited Summary of text..."></textarea>
          <h4 class="wordcount">Word Count:<b id="summary-word-length">50</b></h4>
          <h4 class="wordcount">Character Count:<b id="summary-word-length">200</b></h4>  
      </div>
    </div>
    <div class="row">
        <div class="col-sm-6">

        </div>
        <div class="col-sm-5" style="text-align:right;">
            <button type="button" class="btn btn-success" style="margin-top:15px; margin-bottom: 15px;">Proceed</button>

        </div>
    </div>                   
</div>

<script type="text/javascript">
    function increaseValue() {
        var value = parseInt(document.getElementById('number').value, 10);
        value = isNaN(value) ? 0 : value;
        value++;
        document.getElementById('number').value = value;
    }
    function decreaseValue() {
      var value = parseInt(document.getElementById('number').value, 10);
      value = isNaN(value) ? 0 : value;
      value < 1 ? value = 1 : '';
      value--;
      document.getElementById('number').value = value;
    }
</script>
@endsection