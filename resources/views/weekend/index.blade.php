@extends('layouts.app')

@section("content")
  <div class="container">
    <div class="row">
        <h3>Weekend Schduler Report:</h3>
    </div>
    <div class="row">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Article Image</th>
                    <th>Article heading</th>
                    <th>Article Author</th>
                    <th>Article status</th>
                    <th>Schduled Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                <tr>
                    <td>
                        <img src="{{ $d->article_image }}" width="150" alt="">

                    </td>
                    <td>
                        <a href="{{ url('/view_articles') }}/{{ $d->id }}" target="_blank">{{ $d->article_heading }}</a>
                    </td>
                    <td>
                    {{$d->article_author}}
                    </td>
                    <td>
                        @if( $d->article_status == "Published" )
                            <button class="btn btn-success">Published</button>
                        @else
                            <button class="btn btn-warning">Needs Review</button>
                        @endif
                    </td>
                    <td>{{ $d->publish_datetime }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>
@endsection
