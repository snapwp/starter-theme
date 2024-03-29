<!doctype html>
<html {!! get_language_attributes() !!}>
	<head>
		<meta charset="{{ get_bloginfo('charset') }}">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=1">
		<title>{{ wp_title('') }}</title>

		@wphead
	</head>

	<body class="{{ implode(' ', get_body_class()) }} bg-gray-50">
        @include('partials.navigation')

        <div class="container mx-auto px-4">
			@yield('main')

            @include('partials.footer')
        </div>

		@wpfooter
	</body>
</html>
