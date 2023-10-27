@extends('layouts.app')

@section("content")
<div class="container">
    <div class="row">
        <h3>Twitter Trending Hashtags:</h3>
        <ul>
            @foreach($hashtags as $hashtag)
            <li>{{ $hashtag }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
