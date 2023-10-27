
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
        <div class="row">
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

            
        </div>
        <div class="row space-16">&nbsp;</div>
            <h3 class="text-center">Volv App User Analytics</h3>
            <hr>
            <div class="row">
                <div class="col-sm-2">
                    <div class="thumbnail">
                        <div class="caption text-center" onclick="location.href='#'">
                            <div class="position-relative">
                                <h1>1</h1>
                            </div>
                            <h4 id="thumbnail-label">No. of Users</h4>
                            <div class="thumbnail-description smaller">Total No of Users who downloaded & installed the app. This number includes both Active & Non-Active users since the app made live on App or Play Store.</div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="thumbnail">
                        <a href="{{ url('/activeInactiveUsers') }}">
                            <div class="caption text-center">
                                <div class="position-relative">
                                    <h1>2</h1>
                                </div>
                                <h4 id="thumbnail-label">No. Of Active Users</h4>
                                <label for=""><b>Last 7 days</b></label>
                                <div class="thumbnail-description smaller">These are active users who have at least one activity on app. These activity includes Time spent on article.</div>
                            </div>
                        </a>
                    </div>
                </div>    

                <div class="col-sm-2">
                    <div class="thumbnail">
                        <div class="caption text-center" onclick="location.href='#'">
                            <div class="position-relative">
                                <h1>2</h1>
                            </div>
                            <h4 id="thumbnail-label">No. Of Inactive Users</h4>
                            <label for=""><b>Last 7 days</b></label>
                                <div class="thumbnail-description smaller">These are Inactive users who have at no activity on app. These activity includes Time spent on article.</div>                        </div>
                    </div>
                </div>    

                <div class="col-sm-2">
                    <div class="thumbnail">
                        <div class="caption text-center" onclick="location.href='#'">
                            <div class="position-relative">
                                <h1>3</h1>
                            </div>
                            <h4 id="thumbnail-label">No. Of Users Disabled Notifs</h4>
                            <div class="thumbnail-description smaller">These are unique no of users means all duplicate users with more than one user on same device(Duplicate users) have been excluded.</div>
                        </div>
                    </div>
                </div>    

                <div class="col-sm-2">
                    <div class="thumbnail">
                        <div class="caption text-center" onclick="location.href='#'">
                            <div class="position-relative">
                                <h1>5</h1>
                            </div>
                            <h4 id="thumbnail-label">No. Of Users Enabled Notifs</h4>
                            <div class="thumbnail-description smaller">These are unique no of users means all duplicate users with more than one user on same device(Duplicate users) have been excluded.</div>
                        </div>
                    </div>
                </div>    





                <div class="col-sm-2">
                    <div class="thumbnail">
                        <div class="caption text-center" onclick="location.href='#'">
                            <div class="position-relative">
                                <h1>***</h1>
                            </div>
                            <h4 id="thumbnail-label">No. Of Uninstalled Users</h4>
                            <div class="thumbnail-description smaller">These are no. of uninstalled users who have uninstalled apps from Play Store or App Store. Uninstalled users are total unique users minus inactive users.</div>
                        </div>
                    </div>
                </div>    

<!--                 <div class="col-sm-2">
                    <div class="thumbnail">
                        <div class="caption text-center" onclick="location.href='#'">
                            <div class="position-relative">
                                <h1>5,850</h1>
                            </div>
                            <h4 id="thumbnail-label">No. of Duplicate Users</h4>
                            <div class="thumbnail-description smaller">Duplicate users are the no of users who installed app once on mobile devide & have registered with more than one accounts.</div>
                        </div>
                    </div>
                </div>     -->

        </div>


        <div class="row space-16">&nbsp;</div>
            <div class="row">
                <h3 class="text-center">Volv Notifications Analytics</h3>
                <hr>
                <div class="col-sm-offset-1 col-sm-2">
                    <div class="thumbnail">
                        <div class="caption text-center" onclick="location.href='#'">
                            <div class="position-relative">
                                <h1>***</h1>
                            </div>
                            <h4 id="thumbnail-label">No. of Success</h4>
                            <div class="thumbnail-description smaller">No. of Notification sent successfully from VOLV Dashboard to app users. This success guaranteed by Firebase Cloud Messaging(FCM).</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="thumbnail">
                        <div class="caption text-center" onclick="location.href='#'">
                            <div class="position-relative">
                                <h1>***</h1>
                            </div>
                            <h4 id="thumbnail-label">No. of Failure</h4>
                            <div class="thumbnail-description smaller">No. of Notification failed while sending from VOLV Dashboard to app users. This failure is guaranteed by Firebase Cloud Messaging(FCM).</div>
                        </div>
                    </div>
                </div>    

                <div class="col-sm-2">
                    <div class="thumbnail">
                        <div class="caption text-center" onclick="location.href='#'">
                            <div class="position-relative">
                                <h1>***</h1>
                            </div>
                            <h4 id="thumbnail-label">No. of Received</h4>
                            <div class="thumbnail-description smaller">These are no of notifications received by our users on their mobile devices. This means when user will get the notification on the notification bar.</div>
                        </div>
                    </div>
                </div>    

                <div class="col-sm-2">
                    <div class="thumbnail">
                        <div class="caption text-center" onclick="location.href='#'">
                            <div class="position-relative">
                                <h1>***</h1>
                            </div>
                            <h4 id="thumbnail-label">No. Of Opened</h4>
                            <div class="thumbnail-description smaller">These are no. of notifications opened by the users when they received. (Shekar has to change one API from app in order to get this no correct).</div>
                        </div>
                    </div>
                </div>    

                <div class="col-sm-2">
                    <div class="thumbnail">
                        <div class="caption text-center" onclick="location.href='#'">
                            <div class="position-relative">
                                <h1>***</h1>
                            </div>
                            <h4 id="thumbnail-label">Received but not Opened</h4>
                            <div class="thumbnail-description smaller">These are the no of notifications received by users & not opened.Eg. Notification manager full, Network & Notification removed from bar.</div>
                        </div>
                    </div>
                </div>    

        </div>

    </div>
</div>

@endsection