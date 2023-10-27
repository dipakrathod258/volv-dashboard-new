<!DOCTYPE html>
<html>
<head>
  <title></title>
 <meta charset="utf-8">
      <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

</head>
<body>
<div id="loading_icon">
  
</div>

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

      <!-- <br> -->
      <br>
      <br>
      <li><a href="{{ url('/myDashboard') }}"><i class="fa fa-tachometer"></i>&nbsp;My Dashboard</a></li>
      <li>
       <li>
        <a href="{{ url('/show_trending_news') }}"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;Trending</a>
        </li>
       <li>
          <a href="{{ url('/summarizer') }}"><i class="fas fa-robot" aria-hidden="true"></i>&nbsp;Summarizer</a>
          </li>

        <li>  
              <div class="dropdown" style="margin-top: 10px;">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="border: none;">All Articles
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="{{url('/allDashboard')}}">All Articles</a></li>
                  <li><a href="{{url('/publishedArticles')}}">Published</a></li>
                  <li><a href="{{url('/inProgressArticles')}}">In Progress</a></li>
                  <li><a href="{{url('/needsReviewArticles')}}">Needs Review</a></li>
                </ul>
              </div>
              
        </li>
         <li><a href="{{ url('/create_user') }}"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;Users</a></li> 

        <li><a href="/show_category"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;Categories</a></li>
        <li><a href="/show_guidelines">
        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;Guidelines</a></li> 

     <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
        </a>

        <a style="text-decoration: none;" class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out"></i>&nbsp;{{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
       </form>
     </li>

        @endguest    
        </ul>
    </div>
  </div>
</nav>

    
        <div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-offset-3 col-sm-6">
            <div class="card" style="border: 1px solid #ccc; padding: 5%; border-radius: 25px;background-color: #2B4894;">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
    



</body>
</html>








