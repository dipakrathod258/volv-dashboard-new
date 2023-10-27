
@extends('layouts.app')
<style type="text/css">
    .thumbnail {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5);
    transition: 0.3s;
    min-width: 40%;
    border-radius: 5px;
    }

    .thumbnail-description {
    min-height: 40px;
    }

    .thumbnail:hover {
    cursor: pointer;
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 1);
    }
</style>
@section('title', 'App Analytics')

@section('content')

<div class="container-fluid" style="padding-right: 2%">
    <div class="row">
        <h2 class="text-center"><strong>App Analytics</strong></h2>

        <div class="row space-16">&nbsp;</div>
            <h3 class="text-center">Volv App User Analytics</h3>
            <!-- <a href="{{ url('/month_year_active') }}">Month wise Activity</a> -->
            <!-- <a href="{{ url('/monthYearActiveUsers') }}" target="_blank" class="btn btn-info pull-right">Active User Monthwise</a> -->
            <ul class="pull-right" style="list-style-type: none;">
                
                <li style="margin-bottom: 10px;">
                    <a href="{{ url('/monthYearActiveCount') }}" target="_blank" class="btn btn-info">Active User Monthwise</a>        
                </li>
                <li style="margin-bottom: 10px;">
                    <a href="{{ url('/activity_after_register') }}" target="_blank" class="btn btn-danger">Activity after registration</a>    </li>
                <li style="margin-bottom: 10px;">
                    <a href="{{ url('/activeInactiveUsers') }}" target="_blank" class="btn btn-danger">Activity Inactive Summary</a>                
                </li>
            </ul>
            
            
            <br>

            <hr>
            <div class="row">
                <div class='col-sm-offset-2 col-sm-1'>
                    <form  method="POST" action="{{ url('/activeBasedMonth') }}">
                    {{csrf_field()}}
                        <div class="form-group">
                            <label for="email">Month:</label>
                            <select name="month" id="month" class="form-control">
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Year:</label>
                            <select name="year" id="year" class="form-control">
                                <option value="2020">2020</option>
                                <option value="2019">2019</option>
                            </select>
                        </div>       
                        <input class="btn btn-success" type="submit">                                 
                </form>
                </div>

                <div class="col-sm-2">
                    <div class="thumbnail">
                        <a href="{{ url('/activeInactiveUsers') }}">
                            <div class="caption text-center">
                                <div class="position-relative">
                                    <h1 class="month_active">{{ $monthBasedActive }}</h1>
                                </div>
                                <h4 id="thumbnail-label">No. Of Active Users <br><small style="color: #000;font-weight:bold">({{$monthYear}})</small></h4>
                                <div class="thumbnail-description smaller">These are active users who have at least one activity on app in August-2020. These activity includes time spent on an articles.</div>
                            </div>
                        </a>
                    </div>
                </div>    

                <div class="col-sm-2">
                    <div class="thumbnail">
                        <div class="caption text-center" onclick="location.href='#'">
                            <div class="position-relative">
                                <h1 class="month_inactive">{{ $monthBasedInactive }}</h1>
                            </div>
                            <h4 id="thumbnail-label">No. Of Inactive Users <br><small style="color: #000;font-weight:bold">({{$monthYear}})</small></h4>
                            <div class="thumbnail-description smaller">These are active users who have at least one activity on app in August-2020. These activity includes time spent on an articles</div>
                        </div>
                    </div>
                </div>    




        </div>



        <div class="row">

        <div class="col-sm-2">
            <div class="thumbnail">
                <a href="{{ url('/activeInactiveUsers') }}">
                    <div class="caption text-center">
                        <div class="position-relative">
                            <h1>{{ $active }}</h1>
                        </div>
                        <h4 id="thumbnail-label">No. Of Active Users <br><small style="color: #000;font-weight:bold">(Last 7 Days)</small></h4>
                        <div class="thumbnail-description smaller">These are active users who have at least one activity on app in last 5 days. These activity includes article read, Shares, Notification open etc.</div>
                    </div>
                </a>
            </div>
        </div>    

        <div class="col-sm-2">
            <div class="thumbnail">
                <div class="caption text-center" onclick="location.href='#'">
                    <div class="position-relative">
                        <h1>{{ $inactive }}</h1>
                    </div>
                    <h4 id="thumbnail-label">No. Of Inactive Users <br><small style="color: #000;font-weight:bold">(Last 7 Days)</small></h4>
                    <div class="thumbnail-description smaller">These are active users who have at least one activity on app in last 5 days. These activity includes article read, Shares, Notification open etc.</div>
                </div>
            </div>
        </div>    



        <div class="col-sm-2">
            <div class="thumbnail">
                <a href="{{ url('/activeInactiveUsers') }}">
                    <div class="caption text-center">
                        <div class="position-relative">
                            <h1>{{ $active1 }}</h1>
                        </div>
                        <h4 id="thumbnail-label">No. Of Active Users <br><small style="color: #000;font-weight:bold">(Last Month)</small></h4>
                        <div class="thumbnail-description smaller">These are active users who have at least one activity on app in last 5 days. These activity includes article read, Shares, Notification open etc.</div>
                    </div>
                </a>
            </div>
        </div>    

        <div class="col-sm-2">
            <div class="thumbnail">
                <div class="caption text-center" onclick="location.href='#'">
                    <div class="position-relative">
                        <h1>{{ $inactive1 }}</h1>
                    </div>
                    <h4 id="thumbnail-label">No. Of Inactive Users <br><small style="color: #000;font-weight:bold">(Last Month)</small></h4>
                    <div class="thumbnail-description smaller">These are active users who have at least one activity on app in last 5 days. These activity includes article read, Shares, Notification open etc.</div>
                </div>
            </div>
        </div>    

        <div class="col-sm-2">
            <div class="thumbnail">
                <a href="{{ url('/activeInactiveUsers') }}">
                    <div class="caption text-center">
                        <div class="position-relative">
                            <h1>{{ $active2 }}</h1>
                        </div>
                        <h4 id="thumbnail-label">No. Of Active Users <br><small style="color: #000;font-weight:bold">(Last Year)</small></h4>
                        <div class="thumbnail-description smaller">These are active users who have at least one activity on app in last 5 days. These activity includes article read, Shares, Notification open etc.</div>
                    </div>
                </a>
            </div>
        </div>    

        <div class="col-sm-2">
            <div class="thumbnail">
                <div class="caption text-center" onclick="location.href='#'">
                    <div class="position-relative">
                        <h1>{{ $inactive2 }}</h1>
                    </div>
                    <h4 id="thumbnail-label">No. Of Inactive Users <br><small style="color: #000;font-weight:bold">(Last Year)</small></h4>
                    <div class="thumbnail-description smaller">These are active users who have at least one activity on app in last 5 days. These activity includes article read, Shares, Notification open etc.</div>
                </div>
            </div>
        </div>    


        </div>

    </div>
</div>
<script type="text/javascript">
    $(function() {
        $("#month_based_active_form").on("submit", function(e) {
            e.preventDefault()
        $.ajax({
            url: "{{ url('/activeBasedMonth') }}",
            method: "POST",
            dataType: "JSON",
            headers:{
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },   
            data: {"month": month, "year": year},
            success: function(obj) {
                console.log(obj)
                alert("success")
            },
            error: function(obj) {
                alert("Error")
            }
            })
        })
    })
</script>
@endsection