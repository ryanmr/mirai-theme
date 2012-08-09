
</div><!-- #container -->

<?php do_atomic('after_container'); ?>

<?php do_atomic('before_footer'); ?>

<footer id="site-footer">

	<div id="footer">
		<?php do_atomic('footer'); ?>
	</div>

	<?php do_atomic('inside_footer'); ?>

</footer><!-- footer -->

<?php do_atomic('before_footer'); ?>

<?php wp_footer(); ?>

</body>
</html>