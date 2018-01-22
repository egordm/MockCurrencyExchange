<!DOCTYPE html>
<html lang="en">
@include('partials.head')
<body>

@include('partials.navbar')
@yield('header')

<div class="main root">
	@yield('content')
</div>

@include('partials.footer')

<script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>