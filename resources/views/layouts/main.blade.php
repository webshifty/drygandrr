<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
	<link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
	<div class="wrapper">
        <div class="sidebar">
			@yield('sidebar')
		</div>
		<div class="top">
			@yield('top')
		</div>	
		<div class="content active" data-tab="1">
			@yield('content')
		</div>
	</div>

	@stack('modals')

	<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>