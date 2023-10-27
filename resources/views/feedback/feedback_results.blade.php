@extends('layouts.app')

@section('title','Feedback Lists')
@section("volv_app_users_internal_css")
  <link rel='stylesheet' type="text/css" href="{{ url('assets/css/jquery.datatables.min.css') }}">
@endsection

@section('content')
<div class="container-fluid" style="padding: 0% 3%">
    <div class="row">
        <h3>Feedback Results:</h3>
    	<a href="{{ url('/create_feedback') }}" class="btn btn-success pull-right">Create Feedback</a>
    	<br>
    	<br>
    	<br>
    </div>


    <div class="row">
    <center>
        
        <img src="{{ $feedback->feedback_image }}" width="100">
        <br>
        <br>
                <label>Feedback Title:</label> {{ $feedback->feedback_title }}
    </center>

        <ul>

            <li>
                <label>No of Feedbacks received:</label> {{ count($feedback_results) }}
            </li>
            <li>
                <label>Feedback Type:</label> {{ $feedback->feedback_type }}
            </li>
            <li>
                <label>Feedback Option 1: </label>{{ $feedback->option1 }}
                <br>
                <label>Feedback Option 2: </label>{{ $feedback->option2 }}
                    <br>
                <label>Feedback Option 3: </label>{{ $feedback->option3 }}
            </li>

        </ul>
    </div>
    <div class="row">
        <a href="{{ url('/downloadFeedbackResults') }}/{{ $feedback->id }}" class="btn btn-success pull-right"><i class="fa fa-download"></i> Download</a>
        <br>
        <br>
    	<table class="table table-bordered table-hover table-striped" id="feedback_table">
    		<thead>
    			<tr>
    				<th>SR NO</th>
                    <th>User Name</th>
    				<th>User Email</th>
    				<th>Feedback Answer</th>
    			</tr>
    		</thead>
    		<tbody>
                @if(count($obj)>0)
        			@foreach($obj as $key => $feedback)
        			<tr>
        				<td>{{ 1 }}</td>
                        <td>{{ $feedback[0] }}</td>
        				<td>{{ $feedback[1] }}</td>
        				<td>
                            <ul style="font-weight: bold">                        
                                @foreach($feedback["feedback_answers"] as $feed)
                                    @if($feed == "feedbackComplete")
                                    <li>
                                        <span class="text-success">Feedback Completed</span>
                                    </li>
                                    @elseif($feed == "")
                                    <li>
                                        <span class="text-info">Feedback Visited</span>
                                    </li>
                                    @else
                                    <li>
                                        <span>
                                            @if(is_numeric($feed))
                                                @php
                                                    $feed = number_format(floor($feed*100)/100,2, '.', '');
                                                @endphp
                                                <span class="text-warning">{{ (round($feed*10)) }}</span>
                                            @else
                                                {{ $feed }}
                                            @endif
                                        </span>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </td>                        

        			</tr>
        			@endforeach
                @else
                <tr>
                    <td colspan="3" style="color: red; font-family: italic">No Records found</td>
                    <td></td>
                    <td></td>
                </tr>
                @endif

    		</tbody>
    	</table>
    </div>

</div>
<script type="text/javascript" src="{{ url('assets/js/jquery.datatables.min.js') }}"></script>

<script>
  $(document).ready( function () {
      $('#feedback_table').DataTable({"aaSorting": []});
  } );
</script>

@endsection 	