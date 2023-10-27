@extends('layouts.app')
@section("title","Last week data")
@section('app_user_internal_css')
<link rel='stylesheet' type="text/css" href="{{ url('assets/css/jquery.datatables.min.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <h3>Last Week Data:</h3>
            <a href="{{ url('/getlastWeeksUserData') }}" class="btn btn-success">Back</a>
            <br>

            <hr>
        </div>

        <div class="row">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>App Username</th>
                        <th>Email</th>
                        <th>Date of Registration</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $users[0]->name }}</td>
                        <td>{{ $users[0]->email }}</td>
                        <td>{{ $users[0]->created_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Article Heading</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Time Spent on Article(Secs.)</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($articleObj) >0)
                        @foreach($articleObj as $article)
                        <tr>                        
                            <td>
                                @if(isset($article->article_heading))
                                    {{ $article->article_heading }}                                
                                @endif
                            </td>
                            <td>{{ $article->starttime }}</td>
                            <td>{{ $article->endtime }}</td>
                            <td>{{ $article->time_spent }} Secs</td>
                        </tr>
                        @endforeach
                    @elseif(count($articleObj) == 0)
                        <tr>                        
                            <td>
                               <span><i>No Records found.</i></span>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
@endsection