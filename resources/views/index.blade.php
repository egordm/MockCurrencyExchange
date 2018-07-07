@extends('layouts.default')

@section('navbar_class', 'fixed-top navbar-transparent')

@section('header')
    <div class="page-header section-dark" data-parallax="true"
         style="background-image: url('{{asset('images/landing.jpg')}}')">
        <div class="filter"></div>
        <div class="content-center">
            <div class="container text-center">
                <div class="title-brand">
                    <h1 class="landing-title">C-MEX</h1>
                </div>
                <h3 class="landing-subtitle text-center">Trading made easy and informative!</h3>
                <br>
                <a href="{{route('exchange')}}" class="btn btn-outline-neutral btn-round"><i
                            class="fa fa-hand-spock"></i>Start now!</a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <section class="section section-gray text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto">
                    <h2 class="title">Why even bother?
                        <small>I am a hodler.</small>
                    </h2>
                    <h5>Since cryptocurrencies have become more popular has their price grown exponentially. This has
                        also caused great volatility in the market which introduces many risks and potential gains in
                        trading them. We at C-MEX believe that trading responsibly is important. Therefore we introduce
                        our trading and learning platform for a large variety of cryptocurrencies.</h5>
                </div>
            </div>
        </div>
    </section>
    <section class="section text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto">
                    <h2 class="title">Features</h2>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3">
                    <div class="info">
                        <i class="inline-icon icon-money presentation-icon"></i>
                        <h4 class="info-title">Mock trading</h4>
                        <p>Ever wondered what would happen if you bought that one coin? Now you can trade with virtual
                            money to hone your trading and analyzing skills.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info">
                        <i class="inline-icon icon-choice presentation-icon"></i>
                        <h4 class="info-title">Large choice</h4>
                        <p>We aim to support a large number of crypto currencies, and provide a stable market for
                            smaller niche currencies.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info">
                        <i class="inline-icon icon-secure presentation-icon"></i>
                        <h4 class="info-title">Security</h4>
                        <p>Security is our priority. Therefore we do not store any information on your monetary status
                            nor any real coins.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info">
                        <i class="inline-icon icon-puzzle presentation-icon"></i>
                        <h4 class="info-title">Compatablity</h4>
                        <p>Connect your accounts from different exchanges to use our trading platform on other
                            exchanges.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-dark text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto">
                    <h2 class="title">New to this?</h2>
                    <h5>Our mock exchange is meant to give you an understanding of how crypto trading works. When you
                        are comfortable using it, you can connect other exchanges to trade for real. Our clean trade
                        interface is meant clean and not overwhelming for a beginner.</h5>
                </div>
            </div>
        </div>
    </section>
    <section class="section text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto">
                    <h2 class="title">Made with</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-5 ml-auto mr-auto">
                    <a href="https://laravel.com/" rel="Laravel">
                        <img class="img-fluid" src="{{asset('images/laravel.svg')}}">
                    </a>
                </div>
                <div class="col-md-2 col-5 ml-auto mr-auto">
                    <a href="https://reactjs.org/" rel="React">
                        <img class="img-fluid" src="{{asset('images/react.svg')}}">
                    </a>
                </div>
                <div class="col-md-2 col-5 ml-auto mr-auto">
                    <a href="http://sass-lang.com/" rel="Sass">
                        <img class="img-fluid" src="{{asset('images/sass.svg')}}">
                    </a>
                </div>
                <div class="col-md-2 col-5 ml-auto mr-auto">
                    <a href="https://getbootstrap.com/" rel="Bootstrap">
                        <img class="img-fluid" src="{{asset('images/bootstrap.svg')}}">
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-dark text-center">
        <div class="container">
            <h2 class="title">Our team</h2>
            <div class="row">
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-6 ml-auto mr-auto">
                    <h2 class="title">Join now</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 ml-auto mr-auto">
                    <form action="/register">
                        <div class="text-center">
                            <button class="btn btn-primary btn-lg btn-fill">Sign up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop
