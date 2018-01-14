<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config('branding.title')}} - @yield('title')</title>
    <meta name="description" content="@yield('meta_description')">
    <meta name="keywords" content="@yield('meta_keywords')">

    <!-- Style -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <!-- Javascript -->
    <script src="{{ asset('/js/manifest.js') }}"></script>
    <script src="{{ asset('/js/vendor.js') }}"></script>

    <script>
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>;
    </script>
</head>
<body>
<nav class="navbar navbar-expand-md fixed-top navbar-transparent" color-on-scroll="500">
    <div class="container">
        <div class="navbar-translate">
            <button class="navbar-toggler navbar-toggler-right navbar-burger" type="button" data-toggle="collapse"
                    data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-bar"></span>
                <span class="navbar-toggler-bar"></span>
                <span class="navbar-toggler-bar"></span>
            </button>
            <a class="navbar-brand" href="{{route('home')}}">{{config('branding.title')}}</a>
        </div>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#about" class="nav-link">About</a>
                </li>
                <li class="nav-item">
                    <a href="#login{{--{{route('login')}}--}}" class="nav-link">Account</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('exchange')}}" class="btn btn-primary btn-round">Exchange</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

@yield('header')

<div class="main root">
    <h1>Thanks for reg</h1>
</div>

<footer class="footer section-dark">
    <div class="container">
        <div class="row">
            <nav class="footer-nav">
                <ul>
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li><a href="{{route('exchange')}}">Exchange</a></li>
                    <li><a href="#about">About</a></li>
                </ul>
            </nav>
            <div class="credits ml-auto">
					<span class="copyright">
						© <script>document.write(new Date().getFullYear())</script>, C-MEX
					</span>
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>