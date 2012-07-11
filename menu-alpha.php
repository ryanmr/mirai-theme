<?php if ( has_nav_menu('alpha') ): ?>
	<nav id="menu-alpha" class="menu-container">
		<?php wp_nav_menu(
			array( 'theme_location' => 'alpha',
						 'container_class' => 'menu',
						 'menu_class' => '', 
						 'menu_id' => 'menu-alpha-items', 
						 'fallback_cb' => ''
							)); ?>
	</nav>
<?php endif; ?>