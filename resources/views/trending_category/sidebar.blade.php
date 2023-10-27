<!DOCTYPE html>

<html>
<head>
	<title>Volv Dashboard || Trending ::</title>
  
  <style>

/*a{
color: #fff;
}*/

/*a:hover {
  color: #5fa2db;
}*/
.main-menu1 {
  position: fixed;
}
span {
  font-size: 1em;
}

.minimize {
position: relative;
display: table-cell;
width: 60px;
height: 36px;
text-align: center;
vertical-align: middle;
font-size:20px;
}


.main-menu:hover,nav.main-menu.expanded {
width:200px;
overflow:visible;
}

.main-menu {
background:#337ab7;
border-right:1px solid #e5e5e5;
position:fixed;
top:0;
bottom:0;
height:100%;
padding-right: 80px;
left:0;
margin-top: 98px;
width:60px;
overflow:hidden;
-webkit-transition:width .05s linear;
transition:width .05s linear;
-webkit-transform:translateZ(0) scale(1,1);
z-index:1000;
}

.main-menu>ul {
margin:7px 0;
}

.main-menu li {
position:relative;
display:block;
width:200px;
}

.main-menu li>a {
position:relative;
display:table;
border-collapse:collapse;
border-spacing:0;
color:#fff;
 font-family: 'Lato', sans-serif;;
font-size: 14px;
text-decoration:none;
-webkit-transform:translateZ(0) scale(1,1);
-webkit-transition:all .1s linear;
transition:all .1s linear;
  
}

.main-menu .nav-icon {
position:relative;
display:table-cell;
width:60px;
height:36px;
text-align:center;
vertical-align:middle;
font-size:18px;
}

.main-menu .nav-text {
position:relative;
display:table-cell;
vertical-align:middle;
width:190px;
padding-left: 10px;
  font-family: 'Titillium Web', sans-serif;
}

.main-menu>ul.logout {
position:absolute;
left:0;
bottom:0;
}

.no-touch .scrollable.hover {
overflow-y:hidden;
}

.no-touch .scrollable.hover:hover {
overflow-y:auto;
overflow:visible;
}

a:hover,a:focus {
text-decoration:none;
}

nav {
-webkit-user-select:none;
-moz-user-select:none;
-ms-user-select:none;
-o-user-select:none;
user-select:none;
}

nav ul,nav li {
outline:0;
margin:0;
padding:0;
}
/*.main-menu li:hover>a,nav.main-menu li.active>a,.dropdown-menu>li>a:hover,.dropdown-menu>li>a:focus,.dropdown-menu>.active>a,.dropdown-menu>.active>a:hover,.dropdown-menu>.active>a:focus,.no-touch .dashboard-page nav.dashboard-menu ul li:hover a,.dashboard-page nav.dashboard-menu ul li.active a {
color:#fff;
background-color:#5fa2db;
}
*/
/*.area {
float: left;
background: #e2e2e2;
width: 100%;
height: 100%;
}
*/
body {
  font-family: 'Lato', sans-serif;
}

.card-img-top{
  width: 100%;
    margin-left: 15px;
    margin-top: 15px;
    border-radius: 15px;


}

/*.card {
  height: 170px;
  border: 3px;
  margin-bottom: 15px;
  margin-left: 0px;
  margin-right: 5px;
  border-radius: 15px;
}
.card:first-child {
  
margin-top: 55px;
}
.card-blocks .expanded{
  margin-left: 140px;
}
*/.border-secondary{
 border-color: #b5b9bd!important;;
}

.navbartop {
  position: fixed;
    z-index: 1;
    width: 100%;
}

.main-menu {
  max-height: 90% !important;
  overflow-x: hidden !important;
  overflow-y: scroll !important;
}




  </style>


<script src="{{ url('js/match_jquery.js') }}" type="text/javascript">
$(function() {
	$('.match-height').matchHeight(options);
});
</script>
</head>
<body>


<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark navbartop">
  <a class="navbar-brand" href="">my News Appetite</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse pull-right" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto pull-right">
      <li class="nav-item">
          <a href="#"><i class="fa fa-tachometer"></i>&nbsp;Dashboard&nbsp;&nbsp;&nbsp;</a>
      </li>
      <li class="nav-item">
          <a href="#"><i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;Articles&nbsp;&nbsp;&nbsp;</a>
      </li>
      <li class="nav-item">
          <a href="#"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;Users&nbsp;&nbsp;&nbsp;</a>
      </li>
      <li class="nav-item">
          <a href="#"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;Categories&nbsp;&nbsp;&nbsp;</a>
      </li>
      <li class="nav-item">
          <a href="#"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;Trending&nbsp;&nbsp;&nbsp;</a>
      </li>
      <li class="nav-item">
          <li><a href="#"><i class="fa fa-tasks" aria-hidden="true"></i>&nbsp;User Management&nbsp;&nbsp;&nbsp;</a>
      </li>
      
    </ul>
  </div>
</nav> -->


<nav class="main-menu" style="max-height: 90%;
    overflow-y: auto;
    overflow-x: hidden;">
    <ul>
        <li>
            <a href="{{ url('/show_trending_news') }}">
              <img src="{{ url('/assets/images/US.png') }}" style="margin-left: 3px" alt="us" width="75">
                <span class="nav-text">
                    US
                </span>
            </a>          
        </li>
        <li class="has-subnav">
            <a href="{{ url('/worldNews') }}">
                  <img src="{{ url('/assets/images/world.png') }}" style="margin-left: 3px" alt="us" width="75">
                <span class="nav-text">
                    World
                </span>
            </a>
            
        </li>
        <li class="has-subnav">
            <a href="{{ url('/businessNews') }}">
                  <img src="{{ url('/assets/images/business.png') }}" alt="business" width="75">
                <span class="nav-text">
                    Business
                </span>
            </a>
            
        </li>
        <li class="has-subnav">
            <a href="{{ url('/financeNews') }}">
              <img src="{{ url('/assets/images/finance.png') }}" alt="finance" width="75">
                <span class="nav-text">
                    Finance
                </span>
            </a>
           
        </li>
        <li>
            <a href="{{ url('/entertainmentNews') }}">
              <img src="{{ url('/assets/images/entertainment.png') }}" alt="entertainment" width="75">
                <span class="nav-text">
                   Entertainment
                </span>
            </a>
        </li>
        <li>
            <a href="{{ url('/sportNews') }}">
                  <img src="{{ url('/assets/images/sports.png') }}" alt="sports" width="75">
                <span class="nav-text">
                   Sports
                </span>
            </a>
        </li>
        <li>
           <a href="{{ url('/technologyNews') }}">
                  <img src="{{ url('/assets/images/technology.png') }}" alt="technology" width="75">
                <span class="nav-text">
                    Technology
                </span>
            </a>
        </li>
        <li>
           <a href="{{ url('/trendingNews') }}">
                  <img src="{{ url('/assets/images/trending.png') }}" alt="trending" width="75">
                <span class="nav-text">
                    Trending
                </span>
            </a>
        </li>
        <li>
           <a href="{{ url('/trendingNews') }}">
                  <img src="{{ url('/assets/images/trending.png') }}" alt="trending" width="75">
                <span class="nav-text">
                    Fashion
                </span>
            </a>
        </li>
        <li>
           <a href="{{ url('/trendingNews') }}">
                  <img src="{{ url('/assets/images/trending.png') }}" alt="trending" width="75">
                <span class="nav-text">
                    Entrepreneurship
                </span>
            </a>
        </li>
    </ul>

    
</nav>

