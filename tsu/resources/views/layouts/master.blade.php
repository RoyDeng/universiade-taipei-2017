<!DOCTYPE html>
<html>
	<head>
		<title>@yield('title')</title>
		@include('partials.head')
	</head>
	<body>
		<div class="page-container row-fluid container-fluid">
			@include('partials.nav')
			@include('partials.part')
			@section('content')
			@show
			@include('partials.footer')
		</div>
	</body>
</html> 