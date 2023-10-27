@extends('layouts.app')

@section('title', 'View Polls')

<style type="text/css">
.progress {
    height: 30px !important;
}

.progress-bar {
    font-size: 14px !important;
    line-height: 30px !important;
}
</style>
@section('content')
<div class='container-fluid'>
    <div class='row'>
        <div class='col-sm-3'>
            <h3>Polls:</h3>
        </div>
        <!-- <div class='col-sm-offset-5 col-sm-2'>             
            <label for="">Option1</label>
            <div class="progress">
                <div class="progress-bar progress-bar-striped active" role="progressbar"
                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                    100%
                </div>
            </div>
        </div>
        <div class='col-sm-2'>
                <label for="">Option2</label>
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar"
                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                        100%
                    </div>
                </div>

            </div>
        </div> -->

    </div>

    <div class='row'>

        <table class='table table-bordered table-hover table-striped'>
            <thead>
                <tr>
                    <th>Poll Image</th>
                    <th>Poll Question</th>
                    <!-- <th>Poll Answer 1</th>
                    <th>Poll Answer 2</th> -->
                    <!-- <th>Left color</th>
                    <th>Right color</th> -->
                    <th>Poll Results</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
            @foreach($polls as $key => $poll)
                <tr>
                <td width="100">
                        @if(isset($poll["poll_image"]))
                            <a href="{{ $poll['poll_image']  }}" target="_blank">
                                <img src="{{ $poll['poll_image'] }}"  width='150' alt="">
                            </a></td>
                        @else
                            N.A.
                        @endif

                    <td>{{ $poll["poll_question"]  }}</td>
                    <!-- <td>{{ $poll["option1"]  }}</td>
                    <td>{{ $poll["option2"]  }}</td> -->
                    <!-- <td>
                        <span>#{{ $poll["left_color"]  }}</span>
                        <br>
                        <input type="color" value='#{{ $poll["left_color"]  }}'>
                    </td>
                    <td>
                        <span>#{{ $poll["right_color"]  }}</span>
                        <br>
                        <input type="color" value='#{{ $poll["right_color"]  }}'>
                    </td> -->
                    <td>

                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" style="width:{{ $poll['option1_percent'] }}%">
                        {{ $poll["option1"]  }}&nbsp;&nbsp;&nbsp;
                        <b style="font-size: 15px">{{ $poll['option1_percent'] }}%</b>
                        </div>
                        <div class="progress-bar progress-bar-success" role="progressbar" style="width:{{ $poll['option2_percent'] }}%">
                        {{ $poll["option2"]  }}&nbsp;&nbsp;&nbsp;
                        <b style="font-size: 15px">{{ $poll['option2_percent'] }}%</b>
                        </div>
                        </div>                    
                        <p>No of users chose option1: <b>{{ $poll['option1_count'] }}</b></p>
                        <p>No of users chose option2: <b>{{ $poll['option2_count'] }}</b></p>
                    </td>
                    <td>
                        {{ $poll["created_at"] }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection