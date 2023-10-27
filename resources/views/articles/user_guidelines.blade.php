@extends('layouts.app')
@section('title', 'Guidelines')
@section('content')
  <div class="container">
    <div class="row">
      <h1>User Guidelines</h1>
      {{ date_default_timezone_get() }}
      <p class="text-info"><i class="fa fa-info-circle"></i>&nbsp;<em>This file contains a user guidelines on how to create, edit, update & delete the articles in this dashboard.Click on download icon below to download the guidelines.</em></p>
    </div>
    <div class="row">
      <a href="{{ url('/downloadUserGuidelines') }}" class="btn btn-info">Download&nbsp;<i class="fa fa-download"></i></a>
    </div>

    <!-- //For Admin use only -->
    <div class="row">
      <h3>***For Admin use only***</h3>
      @if(isset($success))
        <div class="alert alert-success">
          <span>Success! File Uploaded successfully.</span>
        </div>
      @endif
      <form action="{{ url('/uploadUserGuidelines') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="user_guidelines_file" style="margin-bottom: 3%;">
        <input type="submit" value="Upload" class="btn btn-success">
      </form>
    </div>
  </div>
@endsection