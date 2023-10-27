@extends('layouts.app')

@section('content')

<div class="container">
<div class="row">
        <div class="col-sm-3">
            <h3>Monthly Reports:</h3>
            <br>
        </div>
        <div class="col-sm-offset-3 col-sm-6">
            <a href="{{ url('/goToDailyReports') }}" class="btn btn-info">Daily Reports</a>
            <a href="{{ url('/goToWeeklyReports') }}" class="btn btn-warning">Weekly Reports</a>
            <a href="{{ url('/goToMonthlyReports') }}" class="btn btn-primary">Monthly Reports</a>
        </div> 
    </div>
    <div class="row">
    <em class='text-info'><i class='fa fa-info-circle'></i>&nbsp;Following are the stats for <b>No. of Articles covered monthly in each category</b>.</em>
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
                    <th>Sci. & Tech.</th>
                    <th>Business</th>
                    <th>Entertainment</th>
                    <th>Sports</th>
                    <th>Fashion</th>
                    <th>Entrepreneur</th>
                    <th>Self-Development</th>
                    <th>Entrepreneur</th>
                    <th>2020 US Elections</th>                    
                </tr>
            </thead>
            <tbody>
                <!-- <tr>
                    <td>18-01-2020</td>
                    <td>12</td>
                    <td>9</td>
                    <td>2</td>
                    <td>1</td>
                    <td>8</td>
                    <td>10</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>1</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>17-01-2020</td>
                    <td>10</td>
                    <td>9</td>
                    <td>2</td>
                    <td>1</td>
                    <td>8</td>
                    <td>10</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>1</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>16-01-2020</td>
                    <td>7</td>
                    <td>9</td>
                    <td>2</td>
                    <td>1</td>
                    <td>8</td>
                    <td>10</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>1</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>15-01-2020</td>
                    <td>8</td>
                    <td>9</td>
                    <td>2</td>
                    <td>1</td>
                    <td>8</td>
                    <td>10</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>1</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>14-01-2020</td>
                    <td>9</td>
                    <td>9</td>
                    <td>2</td>
                    <td>1</td>
                    <td>8</td>
                    <td>10</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>1</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>13-01-2020</td>
                    <td>15</td>
                    <td>9</td>
                    <td>2</td>
                    <td>1</td>
                    <td>8</td>
                    <td>10</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>1</td>
                    <td>5</td>
                </tr> -->

            </tbody>
        </table>

        <h1>IN PROGESSS...</h1>
    </div>
</div>

@endsection