@extends('layouts.app')

@section('title','Create Article')
@section('content')
<div class="container">
    <div class="row">
        <h3>Breaking News:</h3>
        <a href="{{ url('/publishedArticles') }}" class="btn btn-success">Published Articles</a>
        <br>
        <br>
    </div>
    <div class="row">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Article Image</th>
                <th>Article Heading</th>
                <th>Breaking News Duration</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $d)
            <tr>
                <td>
                    <img src="{{ $d->article_image }}" width="200" alt="">
                </td>
                <td>{{ $d->article_heading }}</td>
                <td>{{ $d->breaking_news_period }}</td>
                <td>
                    @if($d->article_visited ==1)
                        <button class="btn btn-success">Active</button>
                    @else
                    <button class="btn btn-danger">Inactive</button>

                    @endif
                </td>
                <td>
                {{ $d->created_at }}
                </td>
                <td>
                    <a href="{{  url('/edit_breaking_news') }}/{{ $d->article_id }}" class="btn btn-info">
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection