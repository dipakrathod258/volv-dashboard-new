@extends("layouts.app")
@@section("new_trending_articles_internal_css")
    <style type="text/css">

    .all_change_white{
      color: white;
    }
    
    #nav-color-change  {
      background-color: #337AB7;
      border:none;
      padding-bottom: 25px;
      /*width: 1470px;*/
      position: fixed;
      display: block;
      z-index: 999;
      -ms-transform: scale(1.2); /* IE 9 */
      -webkit-transform: scale(1.2 )
      transform: scale(1.2);
    }

    #button-color-change{
      background-color:#E8582B;s
      border:none;
    }

    #padding_change{
      padding-left: 80px;
      padding-right: 80px;
    }


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
background:#212121;
border-right:1px solid #e5e5e5;
position:fixed;
top:0;
bottom:0;
height:100%;
padding-right: 80px;
left:0;
margin-top: 100px;
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
color:#999;
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
color: #fff;
/*color:#E8582B; */
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
.main-menu li:hover>a,nav.main-menu li.active>a,.dropdown-menu>li>a:hover,.dropdown-menu>li>a:focus,.dropdown-menu>.active>a,.dropdown-menu>.active>a:hover,.dropdown-menu>.active>a:focus,.no-touch .dashboard-page nav.dashboard-menu ul li:hover a,.dashboard-page nav.dashboard-menu ul li.active a {
color:#fff;
background-color:#5fa2db;
}
.area {
float: left;
background: #e2e2e2;
width: 100%;
height: 100%;
}
body {
  font-family: 'Lato', sans-serif;


}

.card-img-top{
  width: 100%;
    margin-left: 15px;
    margin-top: 15px;
    border-radius: 15px;


}

.card {
  /*height: 170px;*/
  border: 3px;
  margin-bottom: 15px;
  margin-left: 0px;
  margin-right: 5px;
  border-radius: 15px;
}
.card:first-child {
  
/*margin-top: 55px;*/
}
.card-blocks .expanded{
  margin-left: 140px;
}
.border-secondary{
 border-color: #b5b9bd!important;;
}

.navbartop {
  position: fixed;
    z-index: 1;
    width: 100%;
}


/*===Styles By Dipak R*/

.trending_header, .main-menu {
  background-color: #337ab7;
  border: 1px solid #337ab7;
}

.logo {
  border-radius: 50px;  
}

.article_exists_error, .success_msg {
  display: none;
}

#myNavbar ul li:not(:last-child)  {
  border-radius: 25px;
  margin-right: 20px;
}

</style>
@endsection

@section("content")

<nav style="margin-top: 95px; max-height: 900px; overflow-y: scroll;" class="main-menu">
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
           <a href="{{ url('/fashion') }}">
                  <img src="{{ url('/assets/images/trending.png') }}" alt="trending" width="75">
                <span class="nav-text">
                    Fashion
                </span>
            </a>
        </li>
        <li>
           <a href="{{ url('/entrepreneurship') }}">
                  <img src="{{ url('/assets/images/trending.png') }}" alt="trending" width="75">
                <span class="nav-text">
                    Entrepreneurship
                </span>
            </a>
        </li>
        <li>
           <a href="{{ url('/selfDev') }}">
                  <img src="{{ url('/assets/images/trending.png') }}" alt="trending" width="75">
                <span class="nav-text">
                    Self Development
                </span>
            </a>
        </li>
    </ul>

    
</nav>

</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<div class="container ">
  <div class="news_cards  col-sm-3">

    <h4 style="padding-left: 60px;"><b>{{$news_type}}</b></h4>

    <div style="padding-left: 60px;" class="container">
      <div class="row">
        <ul class="alert alert-danger article_exists_error">
          <span><b>Wait!</b>&nbsp;You already have added this article!</span>
        </ul>
        <ul class="alert alert-success success_msg">
          <span><b>Success!</b>&nbsp;This article added successfully to All Articles!</span>
        </ul>
      </div>
      <div class="row">
        <div class=" col-sm-3 pull-right">
          <!-- <label>Filter by priority:</label> -->
<!--           <select class="form-control" id="trending_article_priority" style="margin-left: 380%; margin-bottom: 5%;">
            <option value="Low">Low priority</option>
            <option value="Medium">Medium priority</option>
            <option value="High">High priority</option>
          </select> -->
        </div>

      </div>
      
    </div>

    @if($trending_category_flag =='USNews' || $trending_category_flag =='world' || $trending_category_flag =='sports' || $trending_category_flag =='finance' || $trending_category_flag =='entertainment' || $trending_category_flag =='business' || $trending_category_flag =='technology' || $trending_category_flag =='self development' || $trending_category_flag =='entrepreneurship')
      @include('trending_category.article_card')
    @endif 
    @if($trending_category_flag =='fashion')
      @include('trending_category.article_card_fashion_entr_self') 
    @endif
  </div>  
</div>

<!-- </div> -->

<!-- <div class="p-3 mb-2 bg-dark text-white" style="left:0;bottom:0;height: 50px;text-align: center;" >
  © KRUPA SHAH (Email-shahkrupa25@gmail.com). API source: <a href="https://newsapi.org/" target="_blank">News API</a>
</div>
 -->

<script type="text/javascript">
  $(function() {

    $(".trending_news_priority").on("change", function() {
      val = $(this).val()
      obj = val.split("|");
      trending_article_key = obj[1]
      console.log(trending_article_key)
      $(".trending_news_select_user"+trending_article_key+"").addClass("btn btn-warning")
      // trrending_selector = ".trending_news_select_user"+trending_article_key+" option:nth-child(2)"
      $(".trending_news_select_user"+trending_article_key+" option:nth-child(2)").attr("selected", "selected")

      article_status = $(this).val();
      article_status = obj[0]
      console.log(article_status)

      // if (article_status=="Low") {
      //   $(this).removeClass("btn btn-info btn-warning btn-danger btn-primary")
      //   $(this).addClass("btn btn-warning")
      //   button_class ="btn btn-warning"
      // }
      if (article_status=="Needs Coverage") {
        $(this).removeClass("btn btn-success btn-warning btn-danger btn-primary")
        $(this).addClass("btn btn-warning")
        button_class ="btn btn-warning"
      }
      if (article_status=="Urgent") {
        $(this).removeClass("btn btn-success btn-info btn-warning btn-primary")
        $(this).addClass("btn btn-danger")
        button_class ="btn btn-danger"
      }

      article_title = $(".article_title"+trending_article_key).text()
      article_url = $(".article_url"+trending_article_key).text()
      article_priority = $(".article_priority"+trending_article_key).val()
      console.log(article_title)

      $.ajax({
        url: '{{url("/submit_trending_article")}}',
        headers:{
           'X-CSRF-TOKEN': "{{ csrf_token() }}"
         },   
        method: 'POST',
        type: 'JSON',
        data: { 'article_heading': article_title, 'article_url': article_url, 'article_priority': article_priority, 'button_class': button_class },
        beforeSend: function() {
          $('#loading_icon').show();
          // $(".lds-css").show()
        },
        success: function(obj) {
          // console.log(obj);
          // $(".alert-danger").remove();
          count=0;
          for(i=0;i<obj.length;i++) {
            if(obj[i]!='') {
              count++;
            }
          }
          // console.log(count)
            if (obj.status == "success") {
              $(".article_exists_error, .alert-danger").hide()
              $(".success_msg").show()
              $(".article"+trending_article_key).fadeOut()

              // setTimeout(()=>{
              //   window.location = "{{url('/')}}";
              // },3000);
            }

            // console.log(obj.status == "This article already exists!")

            if (obj.status == "This article already exists!") {
              $(".success_msg, .alert-danger").hide();
              $(".article_exists_error").show()
            }
        },
        error: function(obj) {
          $(".success_msg").hide();
          console.log(obj.responseJSON.errors)

            $('.errors').show()
            $(".errors").empty()
          $.each(obj.responseJSON.errors, function(key, val) {
            // alert("ok")
            $('.errors').append("<li class='alert alert-danger'>"+val+"</li>")
          });
        },
        complete: function() {
          $('#loading_icon',".lds-css").hide();
          $('#loading_icon').hide();
        }
      })
    });

    $(".color_card").on("change", function() {
      val = $(this).val()
        console.log(val)
        if (val=="In Progress") {
          $(this).removeClass("btn btn-success btn-warning btn-primary")
          $(this).addClass("btn btn-info")
          button_class ="btn btn-info"
        }
        if (val=="--Select--") {
          $(this).removeClass("btn btn-success btn-info btn-warning btn-primary")
          $(this).addClass("btn-default")
          button_class ="btn btn-default"
        }
        if (val=="Pending") {
          $(this).removeClass("btn btn-success btn-info btn-primary")
          $(this).addClass("btn btn-warning")
          button_class ="btn btn-warning"
        }
    });

  });

</script>
@endsection