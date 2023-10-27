@extends("layouts.app")

@section('title', 'Notification Report')


@section('content')
<div class="container" style="width: 1500px!important;">
    <div class="row">
        <h3><i class="fa fa-bell"></i>&nbsp;Notifications Report</h3>
    </div>
    <div class="row" style="margin-top: 10px;">
        <table id="notif_report_table" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Article Image</th>
                    <th>Notif Text</th>
                    <th>Created at</th>
                    <th>Notif Open Rate</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notifications as  $key => $d)
                <tr>
                    <td>
                        <img src="{{ $d->article_image }}" alt="" width="100">
                    </td>
                    <td>{{ $d->notification_text }} <a href="{{ url('view_articles') }}/{{$d->id}}">Go to Article <i class="fa fa-arrow-right"></i></a></td>
                    <td>{{ $d->created_at }}</td>
                    <td>
                        <a href="{{ url('/notification_open_rate') }}/{{ $d->id }}" class="btn btn-info">Open Rate</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
$(function() {
    $("#notif_report_table").dataTable()
})
</script>
@endsection
