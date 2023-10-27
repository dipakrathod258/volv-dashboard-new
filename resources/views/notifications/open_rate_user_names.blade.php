@extends("layouts.app")

@section('title', 'Notification Open Rate')


@section('content')
<div class="container" style="width: 1500px!important;">
    <div class="row">
        <h3><i class="fa fa-bell"></i>&nbsp;Notifications Open Rate</h3>
    </div>
    <div class="row" style="margin-top: 10px;">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Notification Image</th>
                    <th>Notification text</th>
                    <th>Article heading</th>
                    <th>App User Name</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <img src="{{ $final['article_image'] }}" alt="" width="100">
                    </td>
                    <td>{{ $final['notification_text'] }}</td>
                    <td>{{ $final['article_heading'] }}</td>
                    <td>
                        <ul>
                            @foreach($users as $user)
                                <li>
                                    {{ $user }}
                                </li>
                            @endforeach
                        </ul>
                    </td>            
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
