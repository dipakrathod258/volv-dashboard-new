@extends('layouts.app')

@section('title', 'Article Scheduler')

@section('weeked_article_internal_css')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type='text/css' rel='stylesheet' href="{{ url('/assets/css/jquery.datetimepicker.css') }}"/>
@endsection
@section('content')
    <div class='container'>
        <div class='row'>
            <h3><i class='fa fa-clock-o'></i>&nbsp;Article Scheduler</h3>
        </div>
        <div class='row'>
            <table class='table table-bordered table-hover table-striped' style='width: 100%'>
                <thead>
                    <tr>
                        <th>Article Image</th>
                        <th>Articles</th>
                        <!-- <th>Status</th> -->
                        <th>Article Scheduler</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                    <tr>
                        <td>
                        <img src="{{ $article->article_image}}" alt="" width='200'>

                        </td>
                        <td>
                            <p><b>{{ $article->article_heading}}</b></p>
                            <p>{{ $article->article_summary}} </p>
                        </td>
                        <!-- <td>
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

                    </td> -->
                    <td width='25%'>
                            <input type="text" class='form-control date-format' name='schedule_time'placeholder='Set publish time here...'>
                            <br>
                            <button class='btn btn-success schedule_btn' id="{{ $article->id }}">Schedule</button>
                        </td>

                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.js'></script>
    <script type='text/javascript' src="{ url('/assets/js/jquery.datetimepicker.js') }}"></script>
    <script>
        $(function() {
            // $('#date-format').bootstrapMaterialDatePicker({ format : 'dddd DD MMMM YYYY - HH:mm' });
            // $('#date-format').bootstrapMaterialDatePicker({ format : 'DD/MM/YYYY HH:mm' });

            $('.date-format').datetimepicker({
                inline:true,
            });


            $('.schedule_btn').on('click', function() {                
                article_id = $(this)[0].id
                article_id = $("").val()
                url = 'schedule_weekend_article/'+article_id
                $.ajax({
                    url: url,
                    headers:{
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },   
                    method: 'GET',
                    beforeSend: function() {
                    $('#loading_icon').show();
                    },
                    success: function(obj) {
                    console.log("success");
                    },
                    error: function(obj) {
                    },
                    complete: function() {
                    }
                })
            });
        })
    </script>
@endsection