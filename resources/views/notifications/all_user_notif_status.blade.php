@extends("layouts.app")

@section('title', 'All User Notification Status')


@section('content')
<div class="container" style="width: 1500px!important;">
    <div class="row">
        <h3><i class="fa fa-bell"></i>&nbsp;All User Notifications Status</h3>
    </div>
    <div class="row">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Article Image</th>
                    <th>Article Title</th>
                    <th>App User Name</th>
                    <th>Notification Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                <tr>
                    <td><img src="{{ $d->article_image }}" alt="" width="50"></td>
                    <td>{{ $d->article_heading }}</td>
                    <td>{{ $d->app_username }}</td>
                    <td>
                        @if($d->sent_status == "NotRegistered")
                            <button class="btn btn-warning">Not Registered</button>
                        @elseif($d->sent_status == "InvalidRegistration")
                            <button class="btn btn-danger">Invalid Registration</button>
                        @elseif($d->sent_status == "success")
                            <button class="btn btn-success">Sent</button>
                        @elseif($d->sent_status == "failure")
                            <button class="btn btn-danger">Failure</button>
                        @endif
                    </td>
                    <td>
                        {{ $d->created_at }}
                    </td> 
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
