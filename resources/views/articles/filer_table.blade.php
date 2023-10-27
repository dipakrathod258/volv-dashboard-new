@foreach($articles as $article)


<tr id="{{$article->id}}" 
  class="task-list-row" 
  data-task-id="1"
  data-user="{{$article->article_author}}"
  @foreach($article_statuses as $article_status)
      @if($article_status->status ==$article->article_status)
      data-status="{{$article_status->status}}"
      @endif
  @endforeach
  data-milestone="{{ $article->article_category}}"
  @foreach($priorities as $priority)
    @if($priority == $article->priority_button_class)
      data-priority="{{$priority}}"
    @endif
  @endforeach


  data-tags="Tag 2"
  >
<td>{{$article->id}}</td>
<td>
  <img src="{{$article->article_image}}" width="150"/>
</td>
<td>
  <span>{{ $article->article_category}}</span>
</td>
<td>
  <span><b>{{ $article->article_heading}}</b></span>
  <p style="margin-top: 15px; text-align: justify;">{{ $article->article_summary}}</p>
  <p style="color: #337ab7;"><span><b>Word count: <span class="text-success">{{ str_word_count($article->article_summary) }}</span></b></span>&nbsp;<span class="pull-right"><b>Character Count: <span class="text-success">{{ strlen($article->article_summary) }}</span></b></span></p>
</td>

<td>
@if(isset($article->publisher_title) && $article->article_publisher !=1)
  
{{$article->publisher_title}}
@elseif($article->article_publisher == 1)
{{$article->article_author}}
@endif
<br/>
<a href="{{ url('article_authory_history') }}/{{$article->id}}" target="_blank"><b>History</b></a>

</td>

<td>
{{$article->time_ago}}
<br>
<br>
@if(isset($article->time_stamp))
  {{$article->time_stamp}}
@endif
</td>

<td>

<div class="form-group" style="width: 140px;">

<select class="form-control article{{$article->id}} {{$article->button_class}} article_status" onchange="changeArticleStatus({{ $article->id }}, $(this).val())" id="{{$article->id}}">
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

<!-- <td>
<select class="form-control article_priority{{ $article->id }} {{$article->priority_class}} article_priority  priority_filter_article" onchange="changeArticlePriority({{ $article->id }}, $(this).val())" id="{{$article->id}} ">
  <option value="--Select--">--Select--</option> 
  @foreach($priorities as $priority)
    @if($priority == $article->priority_button_class)
      <option value="{{$priority}}" selected="selected">{{$priority}}</option> 
    @else
      <option value="{{$priority}}">{{$priority}}</option> 
    @endif
  @endforeach
</select>  
</td> -->
<td style="width: 15%;">
  @if(isset($article->publish_datetime) && $article->article_status !="Rollback")
    <span class="pub_date_time{{ $article->id }}"><b>{{ $article->publish_datetime }}</b></span>
    <br>
  @endif
<input type="text" class='form-control date-format datetime{{$article->id}}' placeholder="Choose datetime..." value=""  name='schedule_time'>      
<br>
<button class='btn btn-success schedule_btn' id="{{ $article->id }}">Schedule</button>


</td>

<td>
  <a href="{{ url('/view_articles') }}/{{$article->id}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
  <a href="{{ url('/edit_articles') }}/{{$article->id}}" class="btn btn-primary article_id{{$article->id}}" {{($article->article_status=="Published")? " style= disabled":""}}><i class="fa fa-edit"></i></a>
  <br>
<!--   <a href="{{ url('/delete_articles') }}/{{$article->id}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
 -->
  <a type="button" class="btn btn-danger article_delete_modal_btn" onclick="deleteArticle({{ $article->id }})" data-toggle="modal"  data-target="#myModal"  id="{{$article->id}}"><i class="fa fa-trash" title="Delete"></i></a>

</td>
<input type="hidden" value="{{$currentPage}}">
</tr>
@endforeach


