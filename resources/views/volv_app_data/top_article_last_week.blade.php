@extends('layouts.app')
@section("title","App User Data")
@section('app_user_internal_css')
<link rel='stylesheet' type="text/css" href="{{ url('assets/css/jquery.datatables.min.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <h3>Last Week Summary:</h3>
            <hr>
        </div>
        <div class="row">
<!--         	<table class="table table-bordered table-hover table-striped">
        		<thead>
        			<tr>
        				<th>Top Article</th>
        				<th>Total Read Count</th>
        				<th>Total no of articles read this week</th>
        				<th>Total no of users read articles this week</th>
        			</tr>
        		</thead>
        		<tbody>
        			<tr>
        				<td>
        					<a href="{{ url('/view_articles') }}/{{ $results->article_id }}">{{ $article_heading }}</a>
        				</td>
        				<td>{{ $results->total_read_count }}</td>
        				<td>{{ $results->total_no_of_articles_read_this_week }}</td>
        				<td>{{ $results->total_no_of_users_read_articles_this_week }}</td>
        			</tr>
        		</tbody>
        		
        	</table>
 -->            
            <ul>
                <li>
                    <label>Top Article: <a href="{{ url('/view_articles') }}/{{ $results->article_id }}">{{ $article_heading }}</a></label>
                </li>
                <li>
                    <label>
                        Total Read Count: 
                    </label>{{ $results->total_read_count }}
                </li>
                <li>
                    <label>
                        Total no of articles read this week: 
                    </label> {{ $results->total_no_of_articles_read_this_week }}
                </li>
                <li>
                    Total no of users read articles this week: 
                </li>{{ $results->total_no_of_users_read_articles_this_week }}
            </ul>

        </div>
    </div>
@endsection