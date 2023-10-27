@extends('layouts.app')

@section('title', 'AI | Google Trends')

@section('content')
    <div class="container">
        <div class="row">
            <h3><i class="fa fa-google"></i>&nbsp;<u>Google Trends</u></h3>
            <a href="{{ url('/googleTrends') }}" class="btn btn-info">All</a>
            <a href="{{ url('/googleTrendsBusiness') }}" class="btn btn-success">Business</a>
            <a href="{{ url('/googleTrendsEntertainment') }}" class="btn btn-danger">Entertainment</a>
            <a href="{{ url('/googleTrendsHealth') }}" class="btn btn-warning">Health</a>
            <a href="{{ url('/googleTrendsScienceNTech') }}" class="btn btn-info">Science & Tech</a>
            <a href="{{ url('/googleTrendsSports') }}" class="btn btn-success">Sports</a>
            <a href="{{ url('/googleTrendsTopStories') }}" class="btn btn-primary">Top Stories</a>
        </div>
        <div class="row" style="margin-top: 15px;">
            <h4 class="text-info">{{ $category }}</h4>
        </div>
        <div class="row" style="margin-top: 15px;">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <th>Article Title</th>
                    <th>Article URL</th>
                    <th>Article Source</th>
                    <th>Category</th>
                    <th>Publish Time</th>
                </thead>
                <tbody>
                    @foreach($data as $d)
                    <tr>
                        <td>{{ $d->article_title }}</td>
                        <td><a href="{{ $d->article_url }}" target="_blank">{{ $d->article_url }}</a></td>
                        <td>{{ $d->article_source }}</td>
                        <td>{{ $d->article_category }}</td>
                        <td>{{ $d->article_pubilsh_time }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
