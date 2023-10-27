@extends('layouts.app')

@section('content')

<div class="container">
<div class="row">
        <div class="col-sm-3">
            <h3>Daily Reports:</h3>
            <br>
        </div>
        <div class="col-sm-offset-3 col-sm-6">
            <a href="{{ url('/goToDailyReports') }}" class="btn btn-info">Daily Reports</a>
            <a href="{{ url('/goToWeeklyReports') }}" class="btn btn-warning">Weekly Reports</a>
            <a href="{{ url('/goToMonthlyReports') }}" class="btn btn-primary">Monthly Reports</a>
        </div> 
    </div>


    <div class="row">
    <em class='text-info'><i class='fa fa-info-circle'></i>&nbsp;Following are the stats for <b>No. of Articles covered daily in each category</b>.</em>
            <br>
            <br>

    </div>
    <div class="row">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>US News</th>
                    <th>World</th>
                    <th>Business</th>
                    <th>Sci & Tech</th>
                    <th>Sports</th>
                    <th>Entertainment</th>
                    <th>Fashion</th>
                    <th>Entrepreneur</th>
                    <th>Finance</th>
                    <th>2020 US Elections</th>                    
                </tr>
            </thead>
            <tbody>
                @foreach($final as $key => $f)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ $f['US News'] }}</td>
                    <td>{{ $f['World'] }}</td>
                    <td>{{ $f['Business'] }}</td>
                    <td>{{ $f['Science & Tech'] }}</td>
                    <td>{{ $f['Sports'] }}</td>
                    <td>{{ $f['Entertainment'] }}</td>
                    <td>{{ $f['Fashion'] }}</td>
                    <td>{{ $f['Entrepreneur'] }}</td>
                    <td>{{ $f['Finance'] }}</td>
                    <td>{{ $f['2020 US Elections'] }}</td>

                </tr> 
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection