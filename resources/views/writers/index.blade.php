@extends('layouts.app')

@section("content")
<div class="container">

  <div class="row">
    <h3>Writer Summary</h3>
    <i class="fa fa-info-circle">&nbsp;Published article count for every Content Writer working on Volv dashboard.</i>
    <table class="table table-bordered table-hover"12>
        <thead>
            <tr>
                <th>Author Name</th>
                <th>Published Article Count</th>
            </tr>
        </thead>
        <tbody>
        @foreach($writerSummary as $key => $writer)
            <tr>
                <td>{{ $key }}</td>
                <td>{{ $writer }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
  </div>
</div>
@endsection