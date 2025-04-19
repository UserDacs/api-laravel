		<!-- BEGIN #sidebar -->
		<div id="sidebar" class="app-sidebar">
			<!-- BEGIN scrollbar -->
			<div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
				<!-- BEGIN menu -->
				<div class="menu">
                    <div class="menu-header"></div>
                    <div class="menu-item" id="dashboard" >
						<a href="/admin-dashboard" class="menu-link">
							<div class="menu-icon">
								<i class="material-icons">home</i>
                            </div>
							<div class="menu-text">Dashboard</div>
						</a>
					</div>

                    <div class="menu-item" id="bookings">
						<a href="/admin-bookings" class="menu-link">
							<div class="menu-icon">
								<i class="material-icons">event</i>
                            </div>
							<div class="menu-text">Bookings <span class="badge" style="background: #f45 !important">5</span></div>
						</a>
					</div>

                    <div class="menu-item" id="services">
						<a href="/admin-services" class="menu-link">
							<div class="menu-icon">
								<i class="material-icons">build</i>
                            </div>
							<div class="menu-text">Services</div>
						</a>
					</div>

                    <div class="menu-item" id="shops">
						<a href="/admin-shops" class="menu-link">
							<div class="menu-icon">
								<i class="material-icons">local_mall</i>
                            </div>
							<div class="menu-text">Shop</div>
						</a>
					</div>

                    <div class="menu-item" id="category">
						<a href="/admin-category" class="menu-link">
							<div class="menu-icon">
								<i class="material-icons">category</i>
                            </div>
							<div class="menu-text">Category</div>
						</a>
					</div>



                    <div class="menu-item has-sub " id="users">
						<a href="javascript:;" class="menu-link">
							<div class="menu-icon">
								<i class="material-icons">group</i>
							</div>
							<div class="menu-text">Users </div>
							<div class="menu-caret"></div>
						</a>
						<div class="menu-submenu">
							<div class="menu-item " id="users-admin">
								<a href="/admin-users" class="menu-link"><div class="menu-text">Admin</div></a>
							</div>
							<div class="menu-item" id="users-shop-owner">
								<a href="/admin-users-shops-owner" class="menu-link"><div class="menu-text">Shop owner</div></a>
							</div>
							<div class="menu-item" id="users-technician">
								<a href="/admin-users-technician" class="menu-link"><div class="menu-text">Technician</div></a>
							</div>

                            <div class="menu-item" id="users-customer">
								<a href="/admin-users-customer" class="menu-link"><div class="menu-text">Customer</div></a>
							</div>
						</div>
					</div>


                    <div class="menu-item" id="users-customer_service">
						<a href="/admin-customer_service" class="menu-link">
							<div class="menu-icon">
								<i class="material-icons">headset_mic</i>
                            </div>
							<div class="menu-text">Customer Service <span class="badge" style="background: #f45 !important">5</span></div>
						</a>
					</div>

                    <div class="menu-item" id="ratings">
						<a href="/admin-ratings" class="menu-link">
							<div class="menu-icon">
								<i class="material-icons">star</i>
                            </div>
							<div class="menu-text">Ratings</div>
						</a>
					</div>

                    {{-- <div class="menu-item">
						<a href="widget.html" class="menu-link">
							<div class="menu-icon">
								<i class="material-icons">view_module</i>
                            </div>
							<div class="menu-text">Settings</div>
						</a>
					</div> --}}



				</div>
				<!-- END menu -->
			</div>
			<!-- END scrollbar -->
		</div>
		<div class="app-sidebar-bg"></div>
		<div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a></div>
		<!-- END #sidebar -->
