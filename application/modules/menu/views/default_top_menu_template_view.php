
<ul class="nav navbar-top-links navbar-right">
You are logged in as : <span class="{colour}">{username}      </span>
	{menu}
	<li class="dropdown">
		<a {href_class} href="{href}">
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
<script type="text/javascript">
	// remove disabled elements set in menu_model.php
	$('.disabled').remove();
</script>