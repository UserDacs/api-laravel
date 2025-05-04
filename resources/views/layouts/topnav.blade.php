		<!-- BEGIN #header -->
		<div id="header" class="app-header">
			<!-- BEGIN navbar-header -->
			<div class="navbar-header">
				<button type="button" class="navbar-desktop-toggler" data-toggle="app-sidebar-minify">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="index.html" class="navbar-brand">
					<b class="me-1">{{ config('app.name') }}</b>

				</a>
				<button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<!-- END navbar-header -->
			<!-- BEGIN header-nav -->
			<div class="navbar-nav">
				<div class="navbar-item navbar-form">

				</div>
				<div class="navbar-item dropdown">
					<a href="#" data-bs-toggle="dropdown" class="navbar-link dropdown-toggle icon">
						<i class="fa fa-bell"></i>
						<span id="count-all-notify"></span>
						
					</a>
					<div class="dropdown-menu media-list dropdown-menu-end" style="width: 300px !important">
						<div class="dropdown-header">Notifications (5)</div>
						
						
					</div>
				</div>
				<div class="navbar-item navbar-user dropdown">
					<a href="#" class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
						<img src="{{Auth::user()->image_path}}" alt="" />
						<span class="d-none d-md-inline">{{Auth::user()->firstname . '  ' .  Auth::user()->lastname}}</span> <b class="caret ms-lg-2"></b>
					</a>
					<div class="dropdown-menu dropdown-menu-end me-1">
						<a href="/admin-edit-profile" class="dropdown-item">Edit Profile</a>
                        <a href="#modal-dialog" data-bs-toggle="modal" class="dropdown-item">Change password</a>

						<div class="dropdown-divider"></div>
						<a href="{{ route('logout') }}" class="dropdown-item">Log Out</a>
					</div>
				</div>
			</div>
			<!-- END header-nav -->
		</div>
		<!-- END #header -->
