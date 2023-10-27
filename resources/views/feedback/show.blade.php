@extends('layouts.app')

@section('title','Feedback Lists')
@section('content')
<div class="container-fluid" style="padding: 0% 3%">
    <div class="row">
        <h3>Feedback Lists:</h3>
    	<a href="{{ url('/create_feedback') }}" class="btn btn-success pull-right">Create Feedback</a>
    	<br>
    	<br>
    	<br>
    </div>

    <div class="row">
        @if (Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ Session::get('success') }}</li>
                </ul>
            </div>
        @endif        
    </div>      

    <div class="row">
    	<table class="table table-bordered table-hover table-striped">
    		<thead>
    			<tr>
    				<th>SR NO</th>
    				<th> FeedbackImage</th>
    				<th style="width: 20%;">Title</th>
    				<th style="width: 20%;">Body</th>
    				<th>Option Count</th>
    				<th>Slider Min</th>
    				<th>Slider Max</th>
    				<th>Has Slides?</th>
    				<th>Slides Count</th>
    				<th>Status</th>
    				<th>Created At</th>
    				<th>Action</th>
    			</tr>
    		</thead>
    		<tbody>
    			@foreach($feedbacks as $key => $feedback)
    			<tr>
    				<td>{{ $key+1 }}</td>
    				<td>
    					<img src="{{ $feedback->feedback_image }}" width="100">
    				</td>
    				<td>{{ $feedback->feedback_title }}</td>
    				<td>{{ $feedback->feedback_body }}</td>
    				<td>{{ $feedback->options_count }}</td>
    				<td>{{ $feedback->slider_min }}</td>
    				<td>{{ $feedback->slider_max }}</td>
    				<td>{{ $feedback->has_slides }}</td>
    				<td>{{ $feedback->slides_count }}</td>
    				<td>
                        <select id="feedback_status" data-id="{{$feedback->id}}" class="feedback_status form-control btn <?php if($feedback->feedback_published == 'Published') echo 'btn-success'; else if($feedback->feedback_published == 'Rollback') echo 'btn-danger';   else echo('btn btn-default')?>">
                            @foreach($status_options as $status)
                                @if($status == $feedback->feedback_published)
                                    <option value="{{ $status }}" selected>{{ $status }}</option>
                                @else
                                    <option value="{{ $status}}">{{$status}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
    				<td>
    					{{ $feedback->created_at }}
    				</td>
    				<td>
    					<a href="{{ url('display_feedback') }}/{{ $feedback->id }}" class="btn btn-info">
    						<i class="fa fa-eye"></i>
    					</a>
    					<a href="#" class="btn btn-danger">
    						<i class="fa fa-trash"></i>
    					</a>

    					<a href="#" class="btn btn-primary">
    						<i class="fa fa-edit"></i>
    					</a>
                        <br>
                        <br>
                        <a href="{{ url('/feedback_results') }}/{{ $feedback->id }}" class="btn btn-success">Results</a>

    				</td>

    			</tr>
    			@endforeach
    		</tbody>
    	</table>
    </div>

</div>
<script type="text/javascript">
    $(function() {
        $(".feedback_status").on("change", function() {
            status = $(this).val()

            feedback_id = $(this).attr("data-id")

            console.log("feedback_id")
            console.log(feedback_id)

              $.ajax({
                url: "{{ url('/updateFeedbackStatus') }}/"+feedback_id,
                method: "POST",
                dataType: "JSON",
                headers:{
                         'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },   
                data: {"feedback_published": status},
                success: function(obj) {
                    console.log(obj)
                    if (status == "Published") {
                        $(this).removeClass("btn btn-danger")
                        $(this).addClass("btn btn-success")
                    }



                  swal({
                      title: "Feedback Status Update",
                      text: "Status updated successfully!",
                      icon: "success",
                      buttons: [
                        'Cancel',
                        'OK'
                      ],
                  })


                    setTimeout(()=>{
                      window.location = "{{url('/show_feedbacks')}}";
                    });
                },
                error: function(obj) {
                  alert("Error")
                }

              })
        })
    })
</script>
@endsection 	