@extends('layouts.app')
@section("title","App User Data")
@section('app_user_internal_css')
<link rel='stylesheet' type="text/css" href="{{ url('assets/css/jquery.datatables.min.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <h3>Avg Time Spent Per User Per Week:</h3>
            <hr>
        </div>
        <div class="row">
            <table id="app_user_list_table" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Avg Time Spent on App(Secs)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                    <tr>
                        <td>
                            @if(isset($result->user_name))
                                {{ $result->user_name }}
                            @else
                                NA
                            @endif

                        </td>
                        <td>
                            @if(isset($result->email))
                                {{ $result->email }}
                            @else
                                NA
                            @endif
                        </td>
                        <td>{{ $result->avgTimeSpentOnApp }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

<script type="text/javascript" src="{{ url('assets/js/jquery.datatables.min.js') }}"></script>
<script>
  $(document).ready( function () {
      $('#app_user_list_table').DataTable({"aaSorting": []});
  } );
</script>
@endsection
