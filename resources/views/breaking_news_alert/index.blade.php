@extends('layouts.app')

@section("title", "Breaking News ::")
<style type="text/css"> 
tbody tr td:hover {
    color: #000;
}
</style>
@section("content")
<div class="container-fluid" style="padding: 2%">
    <!-- <div class="row">
        <h3><i class="fa fa-newspaper-o"></i> Breaking News Alerts:</h3>
    </div>
    <div class="row pull-right">
        <ul class="list-inline">
            <li>
                <a href="#">
                    <img src="https://adnas.com/wp-content/uploads/2019/08/fox-news-logo.jpg" alt="" width="50">
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="https://sites.bu.edu/reinhartlab/files/2019/04/BBC-News-LOGO.jpg" alt="" width="50">
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="https://banner2.cleanpng.com/20180713/ljq/kisspng-fox-business-network-fox-news-logo-television-fox-business-logo-5b48395a9da338.4623629515314599306457.jpg" alt="" width="50">
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="https://static01.nyt.com/vi-assets/images/share/1200x675_nameplate.png" alt="" width="50">
                </a>
            </li>
        </ul>
    </div> -->
    <div class="row">
        <div class="col-sm-9">
        <h3>Breaking News Alerts:</h3>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Breaking News</th>
                    <th>Source</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($result as $news)
                <tr>
                    <td><a href="{{$news->link}}" target="_blank">{{ $news->subject }}</a></td>
                    <td>{{ $news->source }}</td>
                    <td>{{ $news->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <div class="col-sm-3" style="background-color: #1c9deb; color: #fff; font-weight: bold">

        <h3><i class="fa fa-twitter"></i> Twitter Trending Hashtags in USA:</h3>
        <table class="table table-bordered table-hover ">
            <thead>
                <tr>
                    <th>Trending #Hashtags</th>
                    <th>Tweet Volume <i class="fa fa-info-circle" style="cursor: pointer" title="No of tweets by Twitter users"></i></th>
                </tr>
            </thead>
            <tbody>
            @foreach($ob as $data)
                <tr>
                    <td>{{ $data[0] }}</td>
                    <td>
                    @if($data[1] != 0)
                        {{ $data[1] }}</td>                    
                    @else
                        N.A.</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>

        <ul></ul>


        </div>
    </div>
</div>
@endsection