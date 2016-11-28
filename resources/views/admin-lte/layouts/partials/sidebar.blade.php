<section class="sidebar">
	@yield('block.sidebar.header')

	<ul class="sidebar-menu">
		{!! theme()->renderNavigation() !!}
	</ul>

	@yield('block.sidebar.footer')
</section>