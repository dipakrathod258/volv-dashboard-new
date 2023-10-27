<nav id="nav-color-change"  class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button id="button-color-change" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ url('/') }}">
        <img style="border-radius: 50px;" class="logo" src="{{asset('assets/imgs/Volv - V.png')}}" width="80" title="Volv Media">
      </a>
    </div>
    <br>  
    
    <div style="border:white;" class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">

      @guest
          <li class="nav-item">
              <a style="color: white;" class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
          </li>
          @if (Route::has('register'))
              <li class="nav-item">
                  <a style="color: white;" class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
              </li>
          @endif
      @else

      <br>
      <li><a style="color: white;" href="{{ url('/myDashboard') }}"><i class="fa fa-tachometer"></i>&nbsp;My Dashboard</a></li>


      <li>

         <li>
          <a style="color: white;" href="{{ url('/publisher/index') }}"><i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;Publishers</a>
        </li>

      <li>
          <a style="color: white;" href="{{ url('/hashtags') }}">#Hashtags</a>
      </li>
      <li>
        <div class="dropdown" style="margin-top: 10px;">
            <button style="color: white;" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="border: none;">All Articles
            <span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="{{url('/allDashboard')}}">All Articles</a></li>
              <li><a href="{{url('/publishedArticles')}}">Published</a></li>
              <li><a href="{{url('/inProgressArticles')}}">In Progress</a></li>
              <li><a href="{{url('/needsReviewArticles')}}">Needs Review</a></li>
              <li><a href="{{url('/republishableArticles')}}">Republishable</a></li>
            </ul>
        </div>              
      </li>

        <li><a style="color: white;" href="{{ url('/create_user') }}"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;Users</a></li> 
        <!-- <li><a style="color: white;" href="{{ url('https://media-bias-prediction.el.r.appspot.com/') }}" target="_blank">Check Bias</a></li>  -->
        
        <li><a style="color: white;" href="/show_category"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;Categories</a></li>

      <li>
        <div class="dropdown" style="margin-top: 10px;">
            <button style="color: white;" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="border: none;">AI
            <span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="{{url('/get_gpt_summarization')}}">AI Summarization</a></li>
              <li><a href="{{url('/get_gpt_content')}}">AI Content Safety</a></li>
            </ul>
        </div>              
      </li>




        <li><a style="color: white;" href="{{ url('/show_feedbacks') }}"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;Feedback</a></li>

        <li>
        <div class="dropdown" style="margin-top: 10px;">
          <button style="color: white;" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="border: none;">Reports
          <span class="caret"></span></button>
          <ul class="dropdown-menu">
            <li><a href="{{url('/goToArticleReports')}}">Articles Reports</a></li>
            <li><a href="{{url('/view_poll')}}">Poll Reports</a></li>
            <li><a href="{{url('/notificatin_report')}}">Notification Reports</a></li>
            <li><a href="{{url('/weekend_schedule_report')}}">Weekend Articles Reports</a></li>
            <li><a href="{{url('/getRefferalDetails')}}">Referrals Reports</a></li>
            <li><a href="{{url('/excel-report')}}">Excel Report</a></li>
          </ul>
        </div>             
        </li>
        <!-- <li>  
                <div class="dropdown" style="margin-top: 10px;">
                  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="border: none;">
                    <i class="fa fa-bell" aria-hidden="true"></i>&nbsp;Notifications
                  <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <a style="text-decoration: none;" class="dropdown-item">
                          &nbsp;No Notifications
                      </a>
                  </ul>
                </div>
                
          </li> -->
          <!-- <li>
            <a style="color: white;" href="/volv_app_users">
            <i class="fa fa-user" aria-hidden="true"></i>&nbsp;App Users</a>
          </li> -->
          @if(auth()->user()->id == 3 || auth()->user()->id == 5 || auth()->user()->id == 6 || auth()->user()->id == 47 || auth()->user()->id == 59 || auth()->user()->id == 62 || auth()->user()->id == 37)

          <li>
            <div class="dropdown" style="margin-top: 10px;">
              <button style="color: white;" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="border: none;">Volv App Data
              <span class="caret"></span></button>
              <ul class="dropdown-menu">
                <li><a href="{{url('/volv_app_users')}}"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;App Users</a></li>
                <li><a href="{{url('/getlastWeeksUserData')}}"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;Last Weeks Data</a></li>

                <li><a href="{{url('/topArticlesLastWeek')}}"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;Top Article Last Week</a></li>

                <li><a href="{{url('/topTenArticlesLastWeek')}}"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;Top 10 Articles Last Week</a></li>

                <li><a href="{{url('/avgSessionsPerWeekPerUser')}}"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;Avg Session Per User Per Week</a></li>

                <li><a href="{{url('/avgTimeSpentPerUserPerWeek')}}"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;Avg Time Spent Per User Per Week</a></li>



                <!-- <li><a href="{{url('/gettimeSpentLastWeek')}}"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;Time Spent Last Week</a></li> -->
              </ul>
            </div>             
        </li>

        @endif

        <li>
        <a style="color: white;" href="http://stage.volvmedia.com/getPublishedRepublishedArticles">
        <i class="fa fa-bell" aria-hidden="true"></i>&nbsp;Notifications</a>
        </li> 


          <li>  
            <div class="dropdown" style="margin-top: 10px;">
              <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="border: none;">
                {{ Auth::user()->name }}
              <span class="caret"></span></button>
              <ul class="dropdown-menu">
                <a style="text-decoration: none;" class="dropdown-item" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                      <i class="fa fa-sign-out"></i>&nbsp;{{ __('Logout') }}
                  </a>
              </ul>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
              </form>
            </div>                
          </li>

        @endguest    
        </ul>

        <ul class="nav navbar-nav" style="margin-top: 20px;">
          <li>
            
          @if(auth()->user()->id == 3 || auth()->user()->id == 5 || auth()->user()->id == 6 )

            <div class="dropdown" style="margin-top: 10px;">
              <button style="color: white;" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="border: none;">App Analytics
              <span class="caret"></span></button>
              <ul class="dropdown-menu">
                <li><a  target="_blank" href="{{ url('/appAnalytics') }}"><i class="fa fa-mobile"></i>&nbsp;App Analytics</a></li>
                <li><a target="_blank" href="{{url('/activity_after_register')}}">Article Read Analysis</a></li>
                <li><a target="_blank" href="{{url('/article_shared')}}">Article Shared Analysis</a></li>
                <li><a target="_blank" href="{{url('/activeInactiveUsers')}}">Active/Inactive Summary</a></li>
                <!-- <li><a target="_blank" href="{{url('/notification_analysis')}}">Notification Analysis</a></li> -->
                <li><a target="_blank" href="{{url('/notification_breakdown_analysis')}}">Notification Breakdown Analysis</a></li>
              </ul>
            </div>              

          @endif

          </li>          

        </ul>
    </div>
  </div>
</nav>
