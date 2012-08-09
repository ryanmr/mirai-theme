<?php get_header(); ?>

<?php do_atomic('before_content'); ?>

<section id="content" role="main">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<?php do_atomic('before_single'); ?>

	<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

		<?php do_atomic('before_entry'); ?>

		<div class="entry-content">
			<?php the_content(); ?>
		</div>

		<?php do_atomic('after_entry'); ?>

	</article><!-- article -->

	<?php do_atomic('after_single'); ?>

	<?php comments_template( '/comments.php', true ); ?>

<?php endwhile; endif; ?>

</section>

<?php do_atomic('after_content'); ?>

<?php get_footer(); ?>