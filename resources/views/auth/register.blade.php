<!DOCTYPE html>
<html lang="en">
<head>
    <title>Volv Dashboard :: Log In</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />

    <link rel="stylesheet" type="text/css" href="{{ url('design/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/app.css') }}">

    <link rel="stylesheet" type="text/css" href="design/fonts/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="design/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">

    <link rel="stylesheet" type="text/css" href="design/vendor/animate/animate.css">

    <link rel="stylesheet" type="text/css" href="design/vendor/css-hamburgers/hamburgers.min.css">

    <link rel="stylesheet" type="text/css" href="design/vendor/select2/select2.min.css">

    <link rel="stylesheet" type="text/css" href="{{ url('design/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/design/css/main.css') }}">

</head>
<body>
<div class="limiter">
    <div class="container-login100" style="background-image: url('images/img-01.jpg');">
        <div class="wrap-login100 p-t-190 p-b-30">
            <form class="login100-form validate-form" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="login100-form-avatar">
                    <a href='{{ url("/") }}'>
                        <img src="{{ url('/assets/imgs/Volv Logo.png') }}" alt="Volv Dashboard" title="Volv Dashboard">
                    </a>
                </div>
                <span class="login100-form-title p-t-20 p-b-45">
                </span>
                
                <div class="wrap-input100 validate-input m-b-10" data-validate="Name is required">
                    <input class="input100 @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                    <i class="fa fa-user"></i>
                    </span>
                </div>


                <div class="wrap-input100 validate-input m-b-10" data-validate="Username is required">
                    <input class="input100 @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                    <i class="fa fa-user"></i>
                    </span>
                </div>








                <div class="wrap-input100 validate-input m-b-10" data-validate="Password is required">
                    <input class="input100 @error('password') is-invalid @enderror" id="password"  type="password" name="password" placeholder="Password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                    <i class="fa fa-lock"></i>
                    </span>
                </div>
                <div class="container-login100-form-btn p-t-10">
                    <button class="login100-form-btn" type="submit">Register</button>
                </div>
                <div class="text-center w-full p-t-25 p-b-230">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="txt1">Forgot Username / Password?</a>
                @endif
                </div>
                <div class="text-center w-full">
                    <a class="txt1" href="{{ route('register') }}">Create new account<i class="fa fa-long-arrow-right"></i></a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="vendor/jquery/jquery-3.2.1.min.js" type="f8d9b9e6032c104bb4840925-text/javascript"></script>

<script src="vendor/bootstrap/js/popper.js" type="f8d9b9e6032c104bb4840925-text/javascript"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js" type="f8d9b9e6032c104bb4840925-text/javascript"></script>

<script src="vendor/select2/select2.min.js" type="f8d9b9e6032c104bb4840925-text/javascript"></script>

<script src="js/main.js" type="f8d9b9e6032c104bb4840925-text/javascript"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13" type="f8d9b9e6032c104bb4840925-text/javascript"></script>
<script type="f8d9b9e6032c104bb4840925-text/javascript">
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-23581568-13');
	</script>
<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="f8d9b9e6032c104bb4840925-|49" defer=""></script></body>
</html>
