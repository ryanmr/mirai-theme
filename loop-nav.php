
<?php if ( is_singular( 'post' ) ) : ?>

		<div class="navigation-links">
			<?php previous_post_link( '%link', '<span class="previous"><span class="symbol">&lt;</span><span class="direction">Previous</span></span>' ); ?>
			<?php next_post_link( '%link', '<span class="next"><span class="direction">Next</span><span class="symbol">&gt;</span></span>' ); ?>
		</div><!-- .navigation-links -->

	<?php elseif ( !is_singular() && function_exists( 'wp_pagenavi' ) ) : wp_pagenavi(); ?>

	<?php elseif ( !is_singular() && current_theme_supports( 'loop-pagination' ) ) : loop_pagination(); ?>

	<?php elseif ( !is_singular() && $nav = get_posts_nav_link( array( 'sep' => '', 'prelabel' => '<span class="previous"><span class="symbol">&lt;</span><span class="direction">Previous</span></span>', 'nxtlabel' => '<span class="next"><span class="direction">Next</span><span class="symbol">&gt;</span></span>' ) ) ) : ?>

		<div class="navigation-links">
			<?php echo $nav; ?>
		</div><!-- .navigation-links -->

<?php endif; ?>