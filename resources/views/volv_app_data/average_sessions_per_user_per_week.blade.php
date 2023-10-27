@extends('layouts.app')
@section("title","App User Data")
@section('app_user_internal_css')
<link rel='stylesheet' type="text/css" href="{{ url('assets/css/jquery.datatables.min.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <h3>Avg Sessions Per User Per Week:</h3>
            <hr>
        </div>
        <div class="row">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Average Session Per User Per Week</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ (int)$results }} Sessions</td>
                    </tr>
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
