@extends('layouts.app')
@section("title","App User Data")
@section('app_user_internal_css')
<link rel='stylesheet' type="text/css" href="{{ url('assets/css/jquery.datatables.min.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <h3>Select App User:</h3>
            <hr>
        </div>
        <div class="row">
            <table id="app_user_list_table" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>App Username</th>
                        <th>Email</th>
                        <th>Last Week</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ url('/lastWeeksUserData') }}/{{$user->id}}" class="btn btn-info"><i class="fa fa-calendar"></i></a>
                        </td>
                        <!-- <td>
                            <a href="{{ url('/timeSpentLastWeek') }}/{{$user->id}}" class="btn btn-success"><i class="fa fa-calendar"></i></a>
                        </td> -->
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
