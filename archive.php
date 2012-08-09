<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>

<?php do_atomic('before_content'); ?>

<section id="content" role="main">

<?php if ( have_posts() ): ?>

<header class="page-header">
	<h2 class="page-title">
		<?php if ( is_day() ): ?> Daily Archives
		<?php elseif ( is_month() ): ?> Monthly Archives
		<?php elseif ( is_year() ): ?> Yearly Archives
		<?php elseif ( is_category(array('link', 'links')) ): ?> <span class="link">Link Archive</span>
		<?php elseif ( is_category(array('feature', 'featured', 'features')) ): ?> <span class="featured">Feature Archive</span>
		<?php elseif ( is_category(array('aside', 'asides')) ): ?> Aisde Archive
		<?php else: ?> Archives
		<?php endif; ?>
	</h2>
</header>

	<?php while (have_posts()): the_post(); ?>
		<?php get_template_part('loop', 'standard'); ?>
	<?php endwhile; ?>

<?php else: ?>

	<?php get_template_part('loop', 'error'); ?>

<?php endif; ?>

</section>

<?php do_atomic('after_content'); ?>

<?php get_footer(); ?>