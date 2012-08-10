<?php if (!have_posts()): ?>
	<?php get_template_part('loop', 'error'); ?>
<?php endif; ?>

<?php 
	while ( have_posts() ): the_post();
?>

	<aside class="dateline">
		<?php the_date(); ?>
	</aside>

	<?php get_template_part('loop', 'standard'); ?>

<?php endwhile; ?>