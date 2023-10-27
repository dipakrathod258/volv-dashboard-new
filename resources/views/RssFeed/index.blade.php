@extends('layouts.app')
@section('title', 'RSS News')
@section('content')

<div class="container">
  <div class="row">
    <h3><u>RSS Feeds:</u></h3>
    <div>
        <!-- <input type="radio" class="" id="dark_mode_btn"> -->
    </div>
  </div>
  <div class="row">
    <ul class="nav nav-tabs">

        @if(isset($us_tab))
          <li class="active"><a href="{{ url('/getRssFeed') }}">US News</a></li>
        @else
        <li><a href="{{ url('/getRssFeed') }}">US News</a></li>
        @endif

        @if(isset($politics_tab))
          <li class="active"><a href="{{ url('/getRssPoliticsFeed') }}">Politics</a></li>
        @else
        <li><a href="{{ url('/getRssPoliticsFeed') }}">Politics</a></li>
        @endif

        @if(isset($world_tab))
          <li class="active"><a href="{{ url('/getRSSWorldFeed') }}">World</a></li>
        @else
          <li><a href="{{ url('/getRSSWorldFeed') }}">World</a></li>


        @if(isset($trending_tab))
          <li class="active"><a href="{{ url('/getRssTrendingFeed') }}">Trending</a></li>
        @else
        <li><a href="{{ url('/getRssTrendingFeed') }}">Trending</a></li>
        @endif

        @if(isset($entertainment_tab))
          <li class="active"><a href="{{ url('/getRssEntertainmentFeed') }}">Entertainment</a></li>
        @else
        <li><a href="{{ url('/getRssEntertainmentFeed') }}">Entertainment</a></li>
        @endif

        @if(isset($sci_n_tech_tab))
          <li class="active"><a href="{{ url('/getRssSciNTechFeed') }}">Sci. & Tech</a></li>
        @else
        <li><a href="{{ url('/getRssSciNTechFeed') }}">Sci. & Tech</a></li>
        @endif

        @if(isset($business_tab))
          <li class="active"><a href="{{ url('/getRssBusinessFeed') }}">Business</a></li>
        @else
        <li><a href="{{ url('/getRssBusinessFeed') }}">Business</a></li>
        @endif

        @if(isset($finance_tab))
          <li class="active"><a href="{{ url('/getRssFinanceFeed') }}">Finance</a></li>
        @else
        <li><a href="{{ url('/getRssFinanceFeed') }}">Finance</a></li>
        @endif

        @if(isset($fashion_tab))
          <li class="active"><a href="{{ url('/getRssFashionFeed') }}">Fashion</a></li>
        @else
        <li><a href="{{ url('/getRssFashionFeed') }}">Fashion</a></li>
        @endif


        <!-- <li><a data-toggle="tab" href="#menu1">Politics</a></li>
        <li><a data-toggle="tab" href="#menu2">Trending</a></li>
        <li><a data-toggle="tab" href="#menu3">Entertainment</a></li>
        <li><a data-toggle="tab" href="#menu4">Sci. & Tech.</a></li>
        <li><a data-toggle="tab" href="#menu5">Business</a></li> -->
        <!-- <li><a data-toggle="tab" href="#menu6">World</a></li> -->
        @endif
        <!-- <li><a data-toggle="tab" href="#menu7">Finance</a></li>
        <li><a data-toggle="tab" href="#menu8">Fashion</a></li> -->
    </ul>

    <div class="tab-content">
      <div id="home" class="tab-pane fade in active">
        <!-- <h3>US News:</h3> -->
        @include("RssFeed.rss_news_format")
      </div>
      <div id="menu1" class="tab-pane fade">
        <!-- <h3>Politics News:</h3> -->
        @include("RssFeed.rss_news_format")
      </div>
      <div id="menu2" class="tab-pane fade">
        <!-- <h3>Trending News:</h3> -->
        @include("RssFeed.rss_news_format")
      </div>
      <div id="menu3" class="tab-pane fade">
        <!-- <h3>Entertainment News:</h3> -->
        @include("RssFeed.rss_news_format")
      </div>
      <div id="menu4" class="tab-pane fade">
        <!-- <h3>Science & Technology News:</h3> -->
        @include("RssFeed.rss_news_format")
      </div>

      <div id="menu5" class="tab-pane fade">
        <!-- <h3>Business News:</h3> -->
        @include("RssFeed.rss_news_format")
      </div>

      <div id="menu6" class="tab-pane fade">
        <!-- <h3>World News:</h3> -->
        @include("RssFeed.rss_news_format")
      </div>

      <div id="menu7" class="tab-pane fade">
        <!-- <h3>Finance News:</h3> -->
        @include("RssFeed.rss_news_format")
      </div>

      <div id="menu8" class="tab-pane fade">
        <h3>Fashion News:</h3>
        @include("RssFeed.rss_news_format")
      </div>

    </div>

  </div>

</div>
@endsection

