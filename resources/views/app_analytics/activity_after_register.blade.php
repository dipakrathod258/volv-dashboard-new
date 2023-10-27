
@extends('layouts.app')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/histogram-bellcurve.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<style type="text/css">
    
#container {
  height: 400px; 
}

.highcharts-figure, .highcharts-data-table table {
  min-width: 310px; 
  max-width: 800px;
  margin: 1em auto;
}

.highcharts-data-table table {
  font-family: Verdana, sans-serif;
  border-collapse: collapse;
  border: 1px solid #EBEBEB;
  margin: 10px auto;
  text-align: center;
  width: 100%;
  max-width: 500px;
}
.highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}
.highcharts-data-table th {
font-weight: 600;
  padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
  padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}
.highcharts-data-table tr:hover {
  background: #f1f7ff;
}


</style>
@section('title', 'App Analytics')

@section('content')
<div class="container">
    <div class="row">
        <h3>No. of Article Read after User Registered: In Next {{ $days }} Days</h3>

        <div class="col-sm-6">
              <form action="{{ url('/activity_after_register_post') }}" method="POST">
                {{ csrf_field() }}
                
              <select class="form-control" name="monthInMumbai">
                <option value="">--Select--</option>      
                <option value="1">Next 24 hrs</option>      
                <option value="7">Next 1 Week</option>      
                <option value="30">Next 1 Month</option>
              </select>
              <br>
              <br>
              <input type="submit" class="btn btn-success" name="">


              </form>

        </div>
        <div class="col-sm-6">
          
          <ul class="pull-right" style="list-style-type: none;">
            
            <li style="margin-bottom: 10px;">
                <a href="{{ url('/monthYearActiveCount') }}" target="_blank" class="btn btn-info">Active User Monthwise</a>        
            </li>
            <li style="margin-bottom: 10px;">
                <a href="{{ url('/activity_after_register') }}" target="_blank" class="btn btn-danger">Activity after registration</a>    </li>
            <li style="margin-bottom: 10px;">
                <a href="{{ url('/activeInactiveUsers') }}" target="_blank" class="btn btn-success">Activity Inactive Summary</a>
            </li>

            <li style="margin-bottom: 10px;">
                <a href="{{ url('/this_week_article_shared') }}" target="_blank" class="btn btn-warning">This Week Article's Shared</a>
            </li>

        </ul>


        </div>


    </div>

<!--     <div class="row">
      <div id="chartContainer1" style="height: 500px; width: 100%;">

    </div>

 -->
        <div class="row">

          <!-- <div id="chartContainer1" style="height: 300px; width: 100%;"> -->

            <figure class="highcharts-figure">
                <div id="container"></div>
                <p class="highcharts-description">
                  Chart shows the Bell Curve computed automatically from our no of articles ready per user dataset. You can also see scatterplot by clicking on data above.
                </p>
            </figure>

        </div>

</div>

<!DOCTYPE HTML>
<html>
<head>
  <script type="text/javascript">
    function randomNumber(min, max) {
      return Math.round(Math.random() * (max - min) + min);
    }

  // window.onload = function () {
  //   console.log("getRandom")
  //   console.log(randomNumber(1,1000))
  //   data=[]

  //   @foreach($result as $key => $value) 
  //       obj = {x: {{ $value->uid }}, y: {{$value->userActivityCount}} }
  //       data.push(obj)
  //   @endforeach
  //   console.log("data")
  //   console.log(data)

  //   var chart = new CanvasJS.Chart("chartContainer1", {
  //     zoomEnabled: true,
  //     panEnabled: true,
  //     title: {
  //       text: "Article Read after User Registered"
  //     },
  //       showInLegend: true,
  //     legend: {
  //       verticalAlign: "center",
  //       horizontalAlign: "left"
  //     },
  //     axisY: {
  //       title: "No Of Article Read"
  //     },
  //     axisX: {
  //       title: "Volv App Users Registered"
  //     },

  //     data: [
  //     {
  //       type: "column",
  //       dataPoints: data
  //     }
  //     ]
  //   });

  //   chart.render();
  // }

    var dataArray = []

    @foreach($result as $key => $value)
        dataArray.push({{ $value->userActivityCount }})
    @endforeach

    console.log("dataArray")
    console.log(dataArray)

    Highcharts.chart('container', {

        title: {
            text: 'Bell curve'
        },

        xAxis: [{
            title: {
                text: 'Data'
            },
            alignTicks: false
        }, {
            title: {
                text: 'Bell curve'
            },
            alignTicks: false,
            opposite: true
        }],

        yAxis: [{
            title: { text: 'Data' }
        }, {
            title: { text: 'Bell curve' },
            opposite: true
        }],

        series: [{
            name: 'Bell curve',
            type: 'bellcurve',
            xAxis: 1,
            yAxis: 1,
            baseSeries: 1,
            zIndex: -1
        }, {
            name: 'Data',
            type: 'scatter',
            data: dataArray,
            accessibility: {
                exposeAsGroupOnly: true
            },
            marker: {
                radius: 1.5
            }
        }]
    });
  </script>
  <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</head>
</html>
@endsection