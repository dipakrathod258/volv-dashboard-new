@foreach($articles as $article)

  <tr id="{{$article->id}}">

    <td>
      <img src="{{ $article->article_image }}" width="100">
    </td>
    <td>
      <ul>
        @foreach($article->article_category as $category)
        <li>{{ $category }}</li>
        @endforeach
      </ul>
    </td>
    <td>
      <span><b>{{ $article->article_heading}}</b></span>
      <p style="margin-top: 15px; text-align: justify;">{{ $article->article_summary}}</p>
      <p style="color: #337ab7;"><span><b>Word count: <span class="text-success">{{ str_word_count($article->article_summary) }}</span></b></span>&nbsp;<span class="pull-right"><b>Character Count: <span class="text-success">{{ strlen($article->article_summary) }}</span></b></span></p>
    </td>
    <td>{{$article->article_author}}</td>
    <td>
    {{$article->time_ago}}
    <br>
    <br>
    @if(isset($article->time_stamp))
    {{ $article->time_stamp }}
    @endif
    </td>
    @if($article->notification_text != "")
      <td>{{$article->notification_text}}</td>
    @elseif($article->notification_text == "")
      <td>N.A.</td>
    @endif

    <td>
      <label class="container_checkbox">
      <input type="checkbox" class="notification_sequence" value="{{$article->id}}" name="notification_sequence">
      <span class="checkmark"></span>
      </label>
      <br>
      <!-- <input type="number" class="form-control"> -->
      <!-- <select name="notif_sequence" class="form-control notif_sequence">
        <option value="0">Choose</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
      </select> -->
    </td>

    <td>
    <div class="form-group" style="width: 140px;">

    <select class="form-control article{{ $article->id }} {{$article->button_class}} article_status" onchange="changeArticleStatus({{ $article->id }}, $(this).val()) " id="{{$article->id}}">
      @foreach($article_statuses as $article_status)
          @if($article_status->status ==$article->article_status)
          <option value="{{$article_status->status}}" selected="selected">{{$article_status->status}}</option> 
          @elseif($article_status->status !=$article->article_status)
          <option value="{{$article_status->status}}">{{$article_status->status}}</option> 
          @endif
      @endforeach
    </select>


    </div> 
    </td>
    <td>
      <a style="margin: 3%;" href="{{ url('/view_articles') }}/{{$article->id}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
      <br>
      <a style="margin: 3%;" href="{{ url('/edit_articles') }}/{{$article->id}}" class="btn btn-primary article_id{{$article->id}}"  {{($article->article_status=="Published")? "style=pointer-events:none; disabled":""}}><i class="fa fa-edit"></i></a>
      <br>
      <!-- <a href="Dataset is the input function"></a> -->

      <a style="margin: 3%;" type="button" class="btn btn-danger article_delete_modal_btn" onclick="deleteArticle({{ $article->id }})" data-toggle="modal" data-target="#myModal"  id="{{$article->id}}"><i class="fa fa-trash" title="Delete"></i></a>

    </td>
    <td>
      <!-- <a href="{{ url('/notify') }}/{{ $article->id }}" class='btn btn-success notify_btn' title="Dont touch this button unless you have permission from Senior Editor">Notify</a> -->

      <a href="{{ url('/add_poll') }}/{{ $article->id }}" class='btn btn-warning'>Add poll&nbsp;<i class="fa fa-plus"></i></a>
      <br>
      <br>
      <button class="btn btn-info notify_btn" id="{{ $article->id }}">Set Breaking News</button>

    </td>

  </tr>

  <!-- ======Bootstrap modal for asking notification warning begins -->

  <div id="notification_warning_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class='fa fa-bell'></i>&nbsp;Confirm Notification</h4>
        </div>
        <div class="modal-body">
            <!-- This notification will go as a <b>Breaking News</b>. -->
            <br>
            Are you sure you want to send this notification?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info notify_btn modal_notify_btn" id="{{ $article->id }}">Notify</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  <!-- ======Bootstrap modal for asking notification warning ends -->

@endforeach
