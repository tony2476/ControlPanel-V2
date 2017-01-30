		<div class="navbar-default sidebar" role="navigation">
			<div class="sidebar-nav navbar-collapse">
				<ul class="nav" id="side-menu">
					<li class="sidebar-search">
						<div class="input-group custom-search-form">
							<input type="text" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
								<button class="btn btn-default" type="button">
									<i class="fa fa-search"></i>
								</button>
							</span>
						</div>
						<!-- /input-group -->
					</li>
					<li>
						<a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
					</li>
					<li>
						<a href="<?= base_url('admin/brands') ?>"><i class="fa fa-table fa-fw"></i> Account</a>
					</li>
					<li>
						<a href="<?= base_url('admin/categories') ?>"><i class="fa fa-edit fa-fw"></i> Newsletter</a>
					</li>
					<li>
						<a href="<?= base_url('admin/products') ?>"><i class="fa fa-edit fa-fw"></i> Email</a>
					</li>
				</ul>
			</div>
			<!-- /.sidebar-collapse -->
		</div>
		<!-- /.navbar-static-side -->
	</nav>