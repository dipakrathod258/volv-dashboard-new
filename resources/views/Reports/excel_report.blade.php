@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<style type="text/css">
	.main {
		font-family: arial;
	}
</style>
@section('title', 'Weekend Article Reports')
<style type="text/css">
	.bootstrap-datetimepicker-widget {
		z-index: 1600 !important;
		top: 100px;
	}
</style>
@section('content')

<div class="container-fluid main" style="margin-right: 15px;margin-left: 15px;">

<span style="color: red;">Important points</span>
<ol>
	<li>Green slots are available and grey is unavailable.</li>
	<li>These are 30 min interval slots. Don't double schedule 2 articles for one time slot.</li>
	<li>Input the headline for whichever time you have scheduled it for so that other writers can cross reference.</li>
	<li>Before scheduling, double check here. If the slot is taken, schedule it for another.</li>
	<li>Only schedule EDITED articles. If it's not edited, it will publish regardless.</li>
</ol>
	<div class="row">
		<h3><i class='fa fa-clock-o'></i>&nbsp;Weeked Articles:</h3>
	</div>
	<div class="row">
		<table class="table table-bordered table-hover" border="1">
			<thead>
			@if (isset($DateTimes))
				<tr>
					<th style="width: 100px;">Time Slots</th>
					@foreach ($DateTimes as $key => $day)
						<th>{{$key}}</th>
					@endforeach
				</tr>
			@endif
			</thead>
			<tbody>
				@if (isset($day))
					@for ($i = 0; $i < count($day); $i++)
						<tr>
							<td>{{date("h:i A", strtotime($times[$i]))}}</td>
							@foreach ($DateTimes as $key => $time)
								@if ($time[$times[$i]]['id'] != 0)
									<td id="{{$time[$times[$i]]['id']}}" class="openModal" status='{{$time[$times[$i]]["status"]}}' publish-time='{{$time[$times[$i]]["publish_time"]}}' style="background-color: {{$time[$times[$i]]['color']}};">{{$time[$times[$i]]["heading"]}} <b>({{$time[$times[$i]]['status']}})</b> </td>
								@else
									<td class="dialog" id="0" style="background-color: {{$time[$times[$i]]['color']}};"></td>
								@endif
							@endforeach
						</tr>
					@endfor
				@endif
			</tbody>
		</table>
	</div>
</div>

<div id="dialog" title="Scheduled Weekend"></div>





<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Scheduled Weekend</h4>
            </div>
            <div class="modal-body" style="padding-bottom: 50px;">

            </div>
        </div>
    </div>
</div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.js"></script>

<script src="assets/plugins/bootstrap-datetimepicker.min.js"></script>


<script>
	$(function() {
		$( ".openModal" ).on("click", function(event){
			var target = $(this);
			if (target.attr("id") != 0) {
				$("#myModal").find(".modal-body").html(
					$(this).html() + "<br>\
						<br>\
						<form method='POST' class='myForm' action='/excel-report-schedule-change/'>\
							<input name='_token' value='{{ csrf_token() }}' type='hidden'>\
							<input type='hidden' value='" + target.attr("id") + "' name='id'>\
							<label>Status: </label>\
							<select name='status' class='form-control' id='status'>\
								<option value='" + target.attr('status') + "' selected>" + target.attr('status') + "</option>\
								<option value='Weekend'>Weekend</option>\
								<option value='Published'>Published</option>\
							</select>\
							<br>\
							<label>Reschedule: </label>\
							<input type='text' class='form-control datetime' value='" + target.attr('publish-time') + "' name='datetime'>\
							<br>\
							<br>\
							<button id='submit' type='submit' class='btn btn-success pull-right'>Submit</button>\
						</form>\
							");


				var map = {};
				$('#status option').each(function () {
				    if (map[this.value])
				        $(this).hide()
				    map[this.value] = true;
				})

				$("#myModal").modal();
				
			}
		});
	});

	$(document).on("focus", ".datetime", function (e) {
	  $(this).css('z-index','1600 !important');
	  $(this).datetimepicker({
		format: 'YYYY-MM-DD HH:mm:ss'
	  });
	});

  </script>

@endsection