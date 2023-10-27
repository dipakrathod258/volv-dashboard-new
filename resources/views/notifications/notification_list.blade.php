@extends("layouts.app")

@section('title', 'All User Notification Status')


@section('content')
<div class="container" style="width: 1500px!important;">
    <div class="row">
        <h3><i class="fa fa-bell"></i>&nbsp;Notification Sent List</h3>
    </div>
    <div class="row">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Sr.No.</th>
                    <th>Article Image</th>
                    <th>Notification Text</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data as $key => $d)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>
                        <img src="{{ $d->article_image }}" alt="Notification Image" width="100">
                    </td>
                    <td>
                        <a href="{{ url('/all_user_notif_status') }}/{{ $d->id }}">{{ $d->notification_text }}</a>
                    </td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
</div>
@endsection