@extends('layouts.app')
@section("title","App User Data")
@section('app_user_internal_css')
<link rel='stylesheet' type="text/css" href="{{ url('assets/css/jquery.datatables.min.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <h3>Top 10 Articles Last Week:</h3>
            <hr>
        </div>
        <div class="row">
        	<table class="table table-bordered table-hover table-striped">
        		<thead>
        			<tr>
                        <th>Sr No</th>
                        <th>Article Image</th>
        				<th>Article Heading</th>
        				<th>Read Count</th>
        			</tr>
        		</thead>
        		<tbody>
                    @foreach($results as $key => $result)
        			<tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            <img src="{{ $result->article_image }}" width="80">
                        </td>
        				<td>
        					<a href="{{ url('/view_articles') }}/{{ $result->_id }}">{{ $result->article_heading }}</a>
        				</td>
        				<td>{{ $result->total_read }}</td>
        			</tr>
                    @endforeach
        		</tbody>
        		
        	</table>
        </div>
    </div>
@endsection