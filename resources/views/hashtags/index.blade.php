@extends('layouts.app')

@section('title','Create Article')


<script type="text/javascript">
  navigator.serviceWorker.getRegistrations().then(registrations => {
    console.log(registrations);
});
</script>


<style type="text/css">
/* allow room for 3 columns */
.minihastag ul
  {
    list-style-type: none;
    width: 75em;
  }  /* float & allow room for the widest item */
  .minihastag ul li
  {
/*    float: left;
    width: 13em;
    margin-bottom: 10px;
*/

    float: left;
    border: 1px solid #ccc;
    width: 13em;
    margin-bottom: 10px;
    padding: 5px;
    background-color: #ddd;
    border-radius: 5px;
    margin-right: 8px;
}

  }  /* stop the float */
  /* br
  {
    clear: left;
  } */
  div.wrapper
  {
    margin-bottom: 1em;
  }
</style>
@section('content')
<div class="container">
    <div class="row">
    <h3>Hashtags & Mini-hashtags:</h3>

        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Hashtags</th>
                    <th>Mini Hashtags</th>
                </tr>
            </thead>
            <tbody>
                @foreach($finalObj as $hashtags => $minihashtags)
                <tr>
                    <td> {{ $hashtags }} </td>
                    <td class="minihastag">
                        <ul>
                            @foreach($minihashtags as $d) 
                                <li style="color: #E76933">
                                  <a style="color: #E76933" href="{{ url('/searchHashtagArticle') }}/{{ $d }}">#{{ $d }}</a>
                                  &nbsp;
                                  <a class="btn btn-xs btn-danger pull-right minihashtags" id="{{ $d }}"> <i class="fa fa-trash"></i> </a>

                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>        
    </div>
</div>

<script type="text/javascript">
  
  $(function()  {
    $(".minihashtags").on("click", function(e) {
      e.preventDefault()
      minihashtag = $(this)[0].id;
      console.log("this is")
      console.log("minihashtag")
      console.log(minihashtag)
      $.ajax({
        url: "{{ url('/deleteHashtag') }}/"+minihashtag,
        method: "POST",
        dataType: "JSON",
        headers:{
                 'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },   
        data: {"minihashtag": minihashtag},
        success: function(obj) {
          if(obj.status == "success") {
            swal({
                 title: "Deleted!",
                 text: "Mini Hashtags deleted!",
            });
            location.reload()
          }

        },
        error: function(obj) {
          alert("Error")
        }
      })

    })
    
  })
</script>
@endsection
