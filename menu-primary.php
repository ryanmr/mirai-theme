<?php if ( has_nav_menu('primary') ): ?>
	<nav id="menu-primary" class="menu-container">

		<?php do_atomic('before_primary_menu'); ?>

		<?php wp_nav_menu(
			array( 'theme_location' => 'primary',
				   'container_class' => 'menu',
				   'menu_class' => '', 
				   'menu_id' => 'menu-primary-items', 
				   'fallback_cb' => ''
					)); ?>

		<?php do_atomic('after_primary_menu'); ?>

	</nav><!-- #primary-menu .menu-container -->
<?php endif; ?>