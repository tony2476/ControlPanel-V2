<?php
/*echo "<pre>";
echo "menu <br />";
print_r ($menu);
echo "</pre>";*/
?>

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


			{menu}
			<li>
				<a href="{href}">
					{icon} {title}
				</a>
				<ul class="{ul_class}">
					{submenu}
					<li>
						<a href="{href}">
							{icon} {title}
						</a>
					</li>
					{footer}
					{/submenu}
				</ul>
			</li>
			{/menu}

		</ul>
	</div>
	<!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>
<script type="text/javascript">
	$('.disabled').remove();
</script>
