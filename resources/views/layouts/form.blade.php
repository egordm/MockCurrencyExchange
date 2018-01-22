<!DOCTYPE html>
<html lang="en">
@include('partials.head')
<body>

@include('partials.navbar')

<div class="wrapper">
	<div class="page-header" style="background-image: url('{{asset('images/landing.jpg')}}');">
		<div class="filter"></div>
		<div class="container">
			<div class="row">
				<div class="col-lg-5 ml-auto mr-auto">
					<div class="card card-form ml-auto mr-auto @yield('form_class')">
						@yield('content')
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>