<ul class="nav navbar-top-links navbar-right">
	<?php foreach ($menu as $primary) : ?>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<?php echo $primary['title'] ?>
			</a>
			<ul class="<?php echo isset($primary['ul_class']) ? $primary['ul_class'] : '' ?>">
				<?php if (isset($primary['submenu'])) : ?>
					<?php foreach ($primary['submenu'] as $item) : ?>
						<li>
							<a href="<?php echo $item['href'] ?>">
								<?php echo $item['title'] ?>
							</a>
						</li>
						<?php if (($item['footer'])) : ?>
							<li class="divider"></li>
						<?php endif; ?>
					<?php endforeach; ?>	
				<?php endif; ?>
			</ul>
		<?php endforeach; ?>
	</li>
</ul>
<?php // END OF FILE remove once finished.?>
