<!DOCTYPE html>
<html lang="en-US">
<head>
  <title>Volv | @yield('title')</title>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Scripts -->
  <!-- <link rel="icon" href="https://www.volvmedia.com/assets/imgs/volv-fevicon.png" type="image/png" sizes="16x16"/> -->
  <script type="text/javascript" src="{{ url('/assets/js/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('/assets/js/jquery1.min.js') }}"></script>
  <link rel="stylesheet" type="text/css" href="{{ url('/assets/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ url('/assets/css/bootstrap.min.css') }}">
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
  <link href="{{ url('/assets/css/jquery-ui.min.css') }}" rel="stylesheet" />
  <script type="text/javascript" src="{{ url('/assets/js/jquery-ui.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('/assets/js/bootstrap.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('/assets/js/select2.min.js') }}"> </script>
  <link rel="stylesheet" type="text/css" href="{{ url('/assets/css/select2.min.css') }}">
  <script src="{{ url('/assets/js/sweetalert.min.js') }}"></script>
  <link rel="stylesheet" type="text/css" href="{{ url('assets/css/app.css') }}">
  <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
 -->
 <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
  <link href="https://vjs.zencdn.net/7.18.1/video-js.css" rel="stylesheet" />

<!--  <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-messaging.js"></script>
 -->
<!-- <script type="text/javascript">

$(function() {

        navigator.serviceWorker.register('/firebase-messaging-sw.js');

        firebase.initializeApp({
            'messagingSenderId': '953414057384'
        })
        const messaging = firebase.messaging();
        // function initFirebaseMessagingRegistration() {
            messaging
                .requestPermission()
                .then(function () {
                    // messageElement.innerHTML = "Got notification permission";
                    console.log("Got notification permission");
                    return messaging.getToken();
                })
                .then(function (token) {
                    // print the token on the HTML page
                    console.log("Token: " + token);

                    $.ajax({
                        url: "{{ url('/saveBreakingNewsToken') }}",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: {
                            'token': token,
                            'user_id': {{auth()->user()->id}}
                        },
                        method: 'POST',
                        beforeSend: function() {
                            $('#loading_icon').show();
                        },
                        success: function(obj) {
                            // alert("success")
                        },
                        error: function(obj) {
                            // alert("error")
                        },
                        complete: function() {}
                        })

                    // alert(token);
                    // tokenElement.innerHTML = "Token is " + token;
                })
                .catch(function (err) {
                    // errorElement.innerHTML = "Error: " + err;
                    console.log("Didn't get notification permission", err);
                });
        // }
        messaging.onMessage(function (payload) {
            console.log("Message received. ", JSON.stringify(payload));
            // notificationElement.innerHTML = notificationElement.innerHTML + " " + payload.data.notification;
                console.log("payload=========")
                console.log(payload)
                console.log(payload.data)
                console.log(payload["data"])
                console.log(payload.data.notification)
                obj = JSON.parse(payload.data.notification)
                console.log("obj")
                console.log(obj)
                // $.each(obj, function(key, val) {
                //     console.log("Key")
                //     console.log(key)
                //     console.log("Val")
                //     console.log(val)

                    console.log()
                    var notification = new Notification(obj["title"], {
                    // icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
                        body: obj["body"],
                    });

                    var string = 'Hello World!';

                    // Encode the String
                    var encodedString = btoa(string);
                    console.log(encodedString); // Outputs: "SGVsbG8gV29ybGQh"

                    // Decode the String
                    var decodedString = atob(encodedString);
                    console.log(decodedString); // Outputs: "Hello World!"


                // })


        notification.onclick = function() {
        window.open('https://dashboard.volvmedia.com/breaking_news');
        };


        });


        messaging.onTokenRefresh(function () {
            messaging.getToken()
                .then(function (refreshedToken) {
                    console.log('Token refreshed.');
                    console.log('Token refreshed: ' + refreshedToken);
                    // tokenElement.innerHTML = "Token is " + refreshedToken;
                }).catch(function (err) {
                    // errorElement.innerHTML = "Error: " + err;
                    console.log('Unable to retrieve refreshed token ', err);
                });
        });
    })

</script> -->

  @yield("my_dashboard")
  @yield("published_article_internal_css")
  @yield("all_article_internal_css")
  @yield("in_progress_internal_css")
  @yield("edit_article_internal_css")
  @yield("volv_app_users_internal_css")
  @yield("weeked_article_internal_css")
  @yield("internal_css_today_report")
  @yield("app_user_internal_css")
  
  <style>
    body {
      font-family: "Inter", sans-serif;
      font-style: normal;
      font-weight: 300;
      line-height: 142.1%;
      letter-spacing: -0.01em;
      color: #505050;
      background-color: #E4E7EB; 
    }

/*    .dark_mode {
      background-color: #000;
      color: #fff;
      transition: width 2s;
      transition: background-color 500ms ease-in;
    }*/

  </style>
</head>

<body>
@include('layouts.header')
@yield('content')
<script src="https://vjs.zencdn.net/7.18.1/video.min.js"></script>

</body>
</html>