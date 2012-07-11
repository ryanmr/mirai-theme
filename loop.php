<?php if (!have_posts()): ?>
	<?php get_template_part('loop', 'error'); ?>
<?php endif; ?>

<?php 
	$date_display_offset = 0;
	while ( have_posts() ): the_post();
?>

	<?php if ( $date_display_offset++ > 0 ): ?>
		<aside class="dateline">
			<?php the_date(); ?>
		</aside>
	<? endif; ?>

	<?php get_template_part('loop', 'standard'); ?>

<?php endwhile; ?>