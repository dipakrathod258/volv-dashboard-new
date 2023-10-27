@extends('layouts.app')

@section('title', 'Article history')

@section('content')

<div class="container">
  <div class="row">
    <h3>Article history</h3>
  </div>
  <div class="row">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Author Name</th>
                <th>Article Heading</th>
                <th>Article Summary</th>
                <th>Notification Text</th>
                <th>Article Status</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>        
        </thead>
        <tbody>
            @foreach($article_details as $data)
                <tr>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->article_heading }}</td>
                    <td>{{ $data->article_summary }}</td>
                    <td>
                      @if(isset($data->notification_text))
                        {{ $data->notification_text }}
                      @else
                        N.A.
                      @endif    
                    </td>
                    <td>{{ $data->article_status }}</td>
                    <td>{{ $data->created_at }}</td>
                    <td>{{ $data->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
  </div>
</div>

@endsection
