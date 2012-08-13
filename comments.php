<?php
/**
 * Comments Template
 *
 */
?>


<?php do_atomic('before_comments'); ?>

<div id="comments-template">

	<?php if ( have_comments() ): ?>

	<h3 class="comments-header">Comments</h3>

	<div id="comments">

		<ol class="comment-list">
			<?php wp_list_comments( hybrid_list_comments_args() ); ?>
		</ol>

	</div><!-- #comments -->

	<?php endif; ?>

	<?php comment_form(); ?>

</div><!-- #comments-template -->

<?php do_atomic('after_comments'); ?>