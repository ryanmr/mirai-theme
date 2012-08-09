<?php
/**
 * Comment Template
 */

	global $post, $comment;
?>

<li id="comment-<?php comment_ID(); ?>" class="<?php hybrid_comment_class(); ?>">

	<?php do_atomic('before_comment'); ?>

	<div class="comment-text">
		<?php if ('0' == $comment->comment_approved): ?>
			<p class="moderation">Your comment is awaiting moderation.</p>
		<?php endif; ?>

		<?php comment_text($comment->comment_ID); ?>

	</div><!-- .comment-text -->
	
	<?php do_atomic('after_comment'); ?>

	<?php /* no closing tag */ ?>