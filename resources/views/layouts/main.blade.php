<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title')</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
	<script>
		window.__PAGE_STATE__ = {
			routeName: "{{ Route::currentRouteName() }}",
			routes: {
				questions: "{{ route('questions') }}",
				requests: "{{ route('requests') }}",
			},
			userInfo: @json($data['userInfo']),
			countries: @json($data['countries']),
			categories: @json($data['categories']),
		};
	</script>
	<div id="app">
		@yield('content')
	</div>
	<script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>