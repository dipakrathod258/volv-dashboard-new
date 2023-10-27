@extends('layouts.app')
@section('title', 'App Users')
@section("volv_app_users_internal_css")
  <link rel='stylesheet' type="text/css" href="{{ url('assets/css/jquery.datatables.min.css') }}">
@endsection

@section("content")
<div class="container">
  <div class="row">
    <h3><i class="fa fa-user"></i>&nbsp;<b><u>Volv App Users Details:</u></b></h3>
    <br>
    <p>No. of App Users: <b>{{ $app_user_count }}</b></p>
    <hr>
  </div>

    <table class="table table-hover table-bordered" id="volv_app_user_list_table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone No</th>
          <th>Date of Registration</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>
                {{$user->phone}}                
            </td>
            <td>{{$user->created_at}}</td>
          </tr>
        @endforeach

      </tbody>
    </table>


</div>
<script type="text/javascript" src="{{ url('assets/js/jquery.datatables.min.js') }}"></script>

<script>
  $(document).ready( function () {
      $('#volv_app_user_list_table').DataTable({"aaSorting": []});
  } );
</script>
@endsection
