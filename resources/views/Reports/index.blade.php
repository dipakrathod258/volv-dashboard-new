@extends('layouts.app')

@section('title', 'Article Report')

@section('internal_css_today_report')
    <link type='text/css' rel='stylesheet' href="{{ url('/assets/css/bootstrap-datepicker.min.css') }}"/>
    <style type='text/css'>
        #today_article_table td, #today_article_table th {
            color: #fff;
            font-weight: bold;
        }

        #today_article_table tbody tr {
            font-size: 20px;
        }

        #today_article_table td:first-child, #today_article_table th:first-child {
            background-color: #398439 !important;
            border-color: #398439 !important;
        }
        #today_article_table td:nth-child(2), #today_article_table th:nth-child(2) {
            background-color: #269abc !important;
            border-color: #269abc !important;
        }
        #today_article_table td:nth-child(3), #today_article_table th:nth-child(3) {
            background-color: #d58512 !important;
            border-color: #d58512 !important;
        }
        #today_article_table td:nth-child(4), #today_article_table th:nth-child(4) {
            background-color: #a91b47 !important;
            border-color: #a91b47 !important;
        }
        #today_article_table td:nth-child(5), #today_article_table th:nth-child(5) {
            background-color: #ac2925 !important;
            border-color: #ac2925 !important;
        }
        #today_article_table td:nth-child(6), #today_article_table th:nth-child(6) {
            background-color: #FF7F50 !important;
            border-color: #FF7F50 !important;
        }
        #today_article_table td:nth-child(7), #today_article_table th:nth-child(7) {
            background-color: #1455b5 !important;
            border-color: #1455b5 !important;
        }
        #today_article_table td:nth-child(8), #today_article_table th:nth-child(8) {
            background-color: #1ba982 !important;
            border-color: #1ba982 !important;
        }

    </style>
@endsection

@section('content')

<div class="container">

    <div class='row' style='font-family: "Open Sans", sans-serif; ;background-color: #ece8eb; padding: 1%; border: 1px solid #ccc; border-radius: 25px;margin-bottom: 10px;'>
        <div class='col-sm-8'>
            <h3>Today's Report:</h3>
        </div>
        <div class='col-sm-4'>
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' id='date' class="form-control" placeholder='Choose your date...'/>
                    <span class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </span>
                </div>
        </div>


        <br>
        <p>
            <!-- <i class='fa fa-info-circle'></i> <span><em><i>Following are the <b>no. of articles covered TODAY</b> in their respective status.</i></em></span> -->
        </p>
        <table id="today_article_table" class='table table-bordered table-striped table-hover text-center'>
            <thead>
                <tr>
                    <th class='text-center'>Published</th>
                    <th class='text-center'>In Progress</th>
                    <th class='text-center'>Needs Review</th>
                    <th class='text-center'>Edited</th>
                    <th class='text-center'>Rejected</th>
                    <th class='text-center'>Rollback</th>
                    <th class='text-center'>Pending</th>
                    <th class='text-center'>Total Articles</th>
                </tr>
            </thead>
            <tbody>
                <tr style="font-weight: bold; font-size: 20px;">
                    
                    @foreach($response as $count)
                    <td>                        
                        <span id="published_count">
                        {{ $count }}
                        </span>
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row" style=';background-color: #ece8eb; padding: 1%; border: 1px solid #ccc; border-radius: 25px;margin-bottom: 10px;'>
        <div class="col-sm-3">
            <h3>Article Reports:</h3>
            <br>
        </div>
        <div class="col-sm-offset-3 col-sm-6">
            <a href="{{ url('/goToDailyReports') }}" class="btn btn-info">Daily Reports</a>
            <a href="{{ url('/goToWeeklyReports') }}" class="btn btn-warning">Weekly Reports</a>
            <a href="{{ url('/goToMonthlyReports') }}" class="btn btn-primary">Monthly Reports</a>
        </div> 
    <!-- </div>

    <div class="row"> -->
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>SR. No.</th>
                    <th>Article Category</th>
                    <th>Article Status</th>
                    <th>No. of Articles</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($article_count))
                @foreach($article_count as $key => $data)
                    <tr>
                        <td>
                            {{$key+1}}
                        </td>
                        <td>
                        {{ $data['news_type'] }}
                        </td>
                        <td>
                            <button class="btn btn-success">Published</button>
                        </td>
                        <td>
                        {{ $data['count'] }}
                        </td>
                    </tr>

                @endforeach
                @endif
            </tbody>
        </table>

    <!-- </div> -->
</div>
<script type='text/javascript' src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>

<script type='text/javascript' src="{{ url('/assets/js/bootstrap-datepicker.min.js') }}"></script>

<script type='text/javascript'>
    $(function() {
        $('#date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            orientation: "right"
        }).on('change', function() {
            today_date = $("#date").val();

            url = '{{url("/check_today_report")}}/'+today_date

            $.ajax({
              url: url,
              headers:{
                 'X-CSRF-TOKEN': "{{ csrf_token() }}"
               },   
              method: 'get',
              type: 'JSON',
              contentType: false,
              cache: false,
              processData:false,
              beforeSend: function() {
                $('#loading_icon').show();
              },
              success: function(obj) {
                $("#today_article_table tbody").html("<tr><td>"+obj.published+"</td><td>"+obj.needs_review+"</td><td>"+obj.in_progress+"</td><td>"+obj.rollback+"</td><td>"+obj.edited+"</td><td>"+obj.rollback+"</td><td>"+obj.pending+"</td><td>"+obj.total_count+"</td><tr>")
              },
              error: function(obj) {
                console.log("error")
            }
        })
    })
    })
</script>
@endsection