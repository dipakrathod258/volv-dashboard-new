
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
        <h3>No. of Article Shared</h3>
    </div>
    <div class="row">
        <div class="col-sm-4">
        	

            <div class="thumbnail">
                <div class="caption text-center" onclick="location.href='#'">
                    <div class="position-relative">
                        <h1>{{ $total_shares }}</h1>
                    </div>
                    <h4 id="thumbnail-label">Total Shares</h4>
                    <div class="thumbnail-description smaller">These are total no of shares so far which includes Facebook, Instagram, Twitter, Whatsapp, Copy & Share.</div>

        		</div>
    		</div>
    	</div>

        <div class="col-sm-4">
        	

            <div class="thumbnail">
                <div class="caption text-center" onclick="location.href='#'">
                    <div class="position-relative">
                        <h1>{{ $articles_shared->instagram }}</h1>
                    </div>
                    <h4 id="thumbnail-label"><i class="fa fa-instagram"></i> Instagram Shares</h4>
                    <div class="thumbnail-description smaller">These shares includes the count of no of Instagram shares. Means someone shares article on IG stories or with some other user. </div>

        		</div>
    		</div>
    	</div>

        <div class="col-sm-4">
        	


            <div class="thumbnail">
                <div class="caption text-center" onclick="location.href='#'">
                    <div class="position-relative">
                        <h1>{{ $articles_shared->whatsapp }}</h1>
                    </div>
                    <h4 id="thumbnail-label"><i class="fa fa-whatsapp"></i> WhatsApp Shares</h4>
                    <div class="thumbnail-description smaller">These shares includes the count of no of Whatsapp shares. Means someone shares the article. Our users & social media platforms gives the basic ides</div>
                </div>
            </div>
        </div>


        </div>
    <div class="row">
        <div class="col-sm-4">
        	

            <div class="thumbnail">
                <div class="caption text-center" onclick="location.href='#'">
                    <div class="position-relative">
                        <h1>{{ $articles_shared->twitter }}</h1>
                    </div>
                    <h4 id="thumbnail-label"> <i class="fa fa-twitter"></i>Twitter Shares</h4>
                    <div class="thumbnail-description smaller">These shares includes the count of no of twitter shares.</div>

        		</div>
    		</div>
    	</div>

        <div class="col-sm-4">
        	

            <div class="thumbnail">
                <div class="caption text-center" onclick="location.href='#'">
                    <div class="position-relative">
                        <h1>{{ $articles_shared->facebook }}</h1>
                    </div>
                    <h4 id="thumbnail-label"><i class="fa fa-facebook"></i> Facebook Shares</h4>
                    <div class="thumbnail-description smaller">These shares includes the count of no of facebook shares. </div>

        		</div>
    		</div>
    	</div>

        <div class="col-sm-4">
        	


            <div class="thumbnail">
                <div class="caption text-center" onclick="location.href='#'">
                    <div class="position-relative">
                        <h1>{{ $articles_shared->copy }}</h1>
                    </div>
                    <h4 id="thumbnail-label"><i class="fa fa-copy"></i> Copy & Share</h4>
                    <div class="thumbnail-description smaller">These shares includes the count of no of times users copied the article link & shared it with someone.</div>
                </div>
            </div>
        </div>


        </div>

        <div class="row">

          <!-- <div id="chartContainer1" style="height: 300px; width: 100%;"> -->

            <figure class="highcharts-figure">
                <div id="container"></div>
                <p class="highcharts-description">
                  Chart shows the Bell Curve computed automatically from no of articles shared. These number includes Whatsapp, Instagram, Facebook, Twitter, Copy & Share data. You can also see scatterplot by clicking on data above.
                </p>
            </figure>

        </div>
</div>
  <script type="text/javascript">
    function randomNumber(min, max) {
      return Math.round(Math.random() * (max - min) + min);
    }

  // window.onload = function () {
  //   console.log("getRandom")
  //   console.log(randomNumber(1,1000))
  //   data=[]

  //   @foreach($shares as $key => $value) 
  //       obj = {x: {{ $value->uid }}, y: {{$value->articlesShareCount}} }
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

    // var data = [3.5, 3, 3.2, 3.1, 3.6, 3.9, 3.4, 3.4, 2.9, 3.1, 3.7, 3.4, 3, 3, 4,
    //     4.4, 3.9, 3.5, 3.8, 3.8, 3.4, 3.7, 3.6, 3.3, 3.4, 3, 3.4, 3.5, 3.4, 3.2,
    //     3.1, 3.4, 4.1, 4.2, 3.1, 3.2, 3.5, 3.6, 3, 3.4, 3.5, 2.3, 3.2, 3.5, 3.8, 3,
    //     3.8, 3.2, 3.7, 3.3, 3.2, 3.2, 3.1, 2.3, 2.8, 2.8, 3.3, 2.4, 2.9, 2.7, 2, 3,
    //     2.2, 2.9, 2.9, 3.1, 3, 2.7, 2.2, 2.5, 3.2, 2.8, 2.5, 2.8, 2.9, 3, 2.8, 3,
    //     2.9, 2.6, 2.4, 2.4, 2.7, 2.7, 3, 3.4, 3.1, 2.3, 3, 2.5, 2.6, 3, 2.6, 2.3,
    //     2.7, 3, 2.9, 2.9, 2.5, 2.8, 3.3, 2.7, 3, 2.9, 3, 3, 2.5, 2.9, 2.5, 3.6,
    //     3.2, 2.7, 3, 2.5, 2.8, 3.2, 3, 3.8, 2.6, 2.2, 3.2, 2.8, 2.8, 2.7, 3.3, 3.2,
    //     2.8, 3, 2.8, 3, 2.8, 3.8, 2.8, 2.8, 2.6, 3, 3.4, 3.1, 3, 3.1, 3.1, 3.1, 2.7,
    //     3.2, 3.3, 3, 2.5, 3, 3.4, 3];
    var dataArray = []

    @foreach($data as $key => $value)
        dataArray.push({{ $value }})
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
@endsection