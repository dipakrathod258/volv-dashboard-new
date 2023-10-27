@extends("layouts.app")

@section('title', 'Notification Open Rate')


@section('content')
<div class="container" style="width: 1500px!important;">
    <div class="row">
        <h3><i class="fa fa-bell"></i>&nbsp;<b>Notifications Open Rate</b></h3>
    </div>
    <div class="row">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Notification Image</th>
                    <th>Article Heading</th>
                    <th>Notif Text</th>
                    <th>#Opens</th>
                    <th>#Total Users</th>
                    <th>#Unique Users</th>
                    <th>Open Rate(%)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <img src="{{ $article->article_image }}" width="100" alt="">
                    </td>
                    <td>{{ $article->article_heading }}</td>
                    <td>{{ $article->notification_text }}</td>
                    <td>{{ $notificationOpenCount }}</td>
                    <td>{{ $total_users }}</td>
                    <td>{{ $unique_count }}</td>
                    <td style="text-center"><span style="font-size: 25px; font-weight: bold;">{{ round(($notificationOpenCount/$unique_count)*100) }}%</span></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row" style="margin-top: 10px;">
    <h4><b><i class="fa fa-users"></i> Users who opened the Notif:</b></h4>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>App User Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notifOpenUserDetails as $d)
                <tr>
                    <td>
                        {{ $d->name }}
                    </td>
                    <td>{{ $d->email }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
