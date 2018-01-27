<!DOCTYPE html>
<html lang="en">
@include('partials.head')
<body>

@include('partials.navbar')

<div class="main wrapper root">
	@yield('header')

	@yield('content')
</div>

@include('partials.footer')

<script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>