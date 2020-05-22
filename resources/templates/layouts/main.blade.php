<!doctype html>
<html {{ get_language_attributes() }} class="no-js">

	<head>
		<meta charset="{{ get_bloginfo('charset') }}">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=1">
		<title>{{ wp_title('') }}</title>

		@wphead
	</head>

	<body itemscope itemtype="http://schema.org/WebPage" class="{{ implode(' ', get_body_class()) }}">
        @include('partials.navigation')

        <div class="container">
            <main itemscope itemprop="mainContentOfPage">
                @yield('main')
            </main>

            <aside aria-label="Sidebar widgets">
                @section('sidebar')
                    @if(is_active_sidebar('sidebar-main'))
                        @sidebar('sidebar-main')
                    @else
                        <h4>Go to wp-admin to add your first widget</h4>
                    @endif
                @show
            </aside>

            @include('partials.footer')

            @wpfooter
        </div>
	</body>
</html>