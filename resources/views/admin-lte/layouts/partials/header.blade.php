<header class="main-header">
	<!-- Logo -->
	<a href="{{ backend_url('/') }}" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-lg">{!! theme()->logo() !!}</span>

		<!-- logo for regular state and mobile devices -->
		<span class="logo-mini">{!! theme()->logoSmall() !!}</span>
	</a>

	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top" role="navigation">

		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>

		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				@yield('block.navbar.before')

				@if(Auth::check())
				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span class="hidden-xs">{{ auth()->user()->name }}</span>
					</a>

					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header">
							<p>
								{{ auth()->user()->name }}
							</p>
						</li>

						@yield('block.navbar.user.body')

						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-right">
								<a class="btn btn-default btn-flat"
								   onclick="event.preventDefault();
								   document.getElementById('logout-form').submit();">
									Logout
								</a>

								<form id="logout-form" action="{{ backend_url('/logout') }}" method="POST" style="display: none;">
									{{ csrf_field() }}
								</form>
							</div>
						</li>
					</ul>
				</li>
				@endif

				<!-- Control Sidebar Toggle Button -->
				<li>
					<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
				</li>

				@yield('block.navbar.after')
			</ul>
		</div>
	</nav>

</header>

