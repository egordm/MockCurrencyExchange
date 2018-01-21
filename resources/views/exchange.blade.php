<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{config('branding.title')}} - @yield('title')</title>
	<meta name="description" content="@yield('meta_description')">
	<meta name="keywords" content="@yield('meta_keywords')">

	<!-- Style -->
	<link href="{{ asset('/css/exchange.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<!-- Javascript -->
	<script src="{{ asset('/js/manifest.js') }}"></script>
	<script src="{{ asset('/js/vendor.js') }}"></script>

	<script>
		window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>;
	</script>
</head>
<body>
<div id="root" class="exchange"></div>
<script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>