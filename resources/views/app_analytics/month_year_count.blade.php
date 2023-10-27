
@extends('layouts.app')
@section('title', 'App Analytics')

@section('content')
<div class="container">
<div class="row">
                <ul class="pull-right" style="list-style-type: none;">
                
                <li style="margin-bottom: 10px;">
                    <a href="{{ url('/monthYearActiveCount') }}" target="_blank" class="btn btn-info">Active User Monthwise</a>        
                </li>
                <li style="margin-bottom: 10px;">
                    <a href="{{ url('/activity_after_register') }}" target="_blank" class="btn btn-danger">Activity after registration</a>    </li>
                <li style="margin-bottom: 10px;">
                    <a href="{{ url('/activeInactiveUsers') }}" target="_blank" class="btn btn-danger">Activity Inactive Summary</a>
                </li>
            </ul>

</div>
  <div class="row">
    <h3>Active User Count based on Month Year</h3>
  </div>
  <div class="row">
      <div id="chartContainer" style="height: 370px; width: 100%;"></div>

  </div>
</div>

<script type="text/javascript">
window.onload = function () {
            data=[]
            count=1
            @foreach($finalArray as $key => $val)

                monthYear =  "{{$key}}"
                month_year = monthYear.split("-")
                // console.log(month_year[0])
                // console.log(month_year[1])
                // console.log("{{$key}}")
                x_data = new Date(month_year[0], month_year[1])
                console.log("x_data")
                console.log(x_data)
                console.log("valll")
                console.log({{ $val }})

                data.push({x: count, y: {{ $val }}, label: monthYear })
                count+=1
            @endforeach

            console.log("data")
            console.log(data)

var options = {
    animationEnabled: true,  
    title:{
        text: "Monthly Active Users Count - 2019 & 2020"
    },
   axisX: {
        // interval:1,
        // labelMaxWidth: 200,
        labelAngle: 45,
        labelFontFamily:"verdana0",
        valueFormatString: "MMM-YYYY"
    },
    axisY: {
        title: "No. of Active Users",
    },
    data: [{
        type: "column",
        dataPoints: data
    }]
};
console.log("Dateeeeeeeee")
console.log(new Date(2017, 11))
$("#chartContainer").CanvasJSChart(options);

}
</script>
<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>

@endsection