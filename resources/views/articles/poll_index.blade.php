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
                    <th>Option1</th>
                    <th>Option2</th>
                    <th>Poll Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articlePolls as $poll)
                <tr>
                    <td>
                        <img src="{{ $poll->poll_image }}" width="150"  alt="">
                    </td>
                    <td>{{ $poll->poll_question }}</td>
                    <td>{{ $poll->option1 }}</td>
                    <td>{{ $poll->option2 }}</td>
                    <td>
                        <select name="poll_status" id="poll_status" poll="{{ $poll->id }}" class="form-control">
                            @if($poll->poll_published == "Published")
                            <option value="Published" selected>Published</option>
                            @else
                            <option value="Published">Published</option>
                            @endif
                            @if($poll->poll_published == "Rollback")
                            <option value="Rollback" selected>Rollback</option>
                            @else
                            <option value="Rollback">Rollback</option>
                            @endif

                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $("#poll_status").on("change", function() {
            poll_status=$(this).val()
            poll_id=$(this)[0]
            console.log($(this))
        })
        function changePollStatus(poll_id, poll_status) {
            alert(poll_id)
            alert(poll_status)
    if (poll_status == "Published") {
      $(".poll" + poll_id).removeClass("btn btn-info btn-edited btn-warning btn-danger btn-primary btn-republished")
      $(".poll" + poll_id).addClass("btn btn-success")
      button_class = "btn btn-success"

      $(".poll_id" + poll_id).attr("disabled", "disabled");
      $(".poll_id" + poll_id).css("pointer-events", "none");
      $(".pub_date_time" + poll_id).show();
    }

    url = "{{url('/change_poll_status')}}/" + poll_status + "/" + poll_id
    console.log(url)
    $.ajax({
      url: url,
      headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
      },
      method: 'GET',
      beforeSend: function() {
        $('#loading_icon').show();
      },
      success: function(obj) {
        console.log("success");
      },
      error: function(obj) {},
      complete: function() {}
    })
  }



    })
</script>
@endsection