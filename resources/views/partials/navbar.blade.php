<!--suppress ALL -->
<nav class="navbar navbar-expand-md @yield('navbar_class')" color-on-scroll="500">
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
				@if (Auth::check())
					<li class="nav-item">
						<a href="{{route('account')}}" class="nav-link">Account</a>
					</li>
					<li class="nav-item">
						<a href="{{route('portfolio')}}" class="nav-link">Portfolio</a>
					</li>
					<li class="nav-item">
						{!! Form::open(['route' => 'logout']) !!}
						{{Form::submit('Logout', ['class' => 'nav-link'])}}
						{!! Form::close() !!}
					</li>
				@else
					<li class="nav-item">
						<a href="{{route('login')}}" class="nav-link">Login</a>
					</li>
					<li class="nav-item">
						<a href="{{route('register')}}" class="nav-link">Register</a>
					</li>
				@endif
				<li class="nav-item">
					<a href="{{route('exchange')}}" class="btn btn-primary btn-round">Exchange</a>
				</li>
			</ul>
		</div>
	</div>
</nav>