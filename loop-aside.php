<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

	<?php do_atomic('before_entry'); ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

	<?php do_atomic('after_entry'); ?>

</article><!-- article.post -->