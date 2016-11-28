<a href="{{ url(config('sleeping_owl.url_prefix')) }}" class="logo">
	<span class="logo-lg">{!! theme()->logo() !!}</span>
	<span class="logo-mini">{!! theme()->logoSmall() !!}</span>
</a>

<nav class="navbar navbar-static-top" role="navigation">
	<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		<span class="sr-only">Toggle navigation</span>
	</a>

	<div class="navbar-custom-menu">	
		<ul class="nav navbar-nav">
			@yield('block.navbar.left')
		</ul>

		<ul class="nav navbar-nav navbar-right">
			@yield('block.navbar.right')
		</ul>
	</div>
</nav>
