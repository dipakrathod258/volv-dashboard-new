@extends('layouts.app')

@section('title','Create Article')
@section('content')
<div class="container">
    <div class="row">
        <h3>Create Breaking News:</h3>
    </div>
    <div class="row">
        <form class="form-horizontal" action="{{ url('/save_breaking_news') }}">
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Article Image:</label>
                <div class="col-sm-10">
                    <img src="{{ $article_image }}" alt="" width="200">
                </div>
            </div>

            <input type="hidden" name="article_id" value="{{ $article_id }}">

            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Article Heading:</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="email" placeholder="Enter email" value="{{ $article_heading }}">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Article Summary:</label>
                <div class="col-sm-10">
                    <textarea name="article_summary" rows="5" class="form-control" value="{{ $article_summary }}">{{ $article_summary }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Breaking News Duration:</label>
                <div class="col-sm-5">
                    <select name="breaking_news_period" class="form-control">
                        <option value="0">--Select--</option>
                        <option value="12">12</option>
                        <option value="24">24</option>
                        <option value="24">48</option>
                        <option value="24">72</option>
                    </select>
                </div>
            </div>


            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection