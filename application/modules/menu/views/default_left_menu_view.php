<div class="navbar-default sidebar" role="navigation" id="sidebar">
	<div class="sidebar-nav navbar-collapse">
		<ul class="nav" id="side-menu">
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
