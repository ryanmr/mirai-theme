<?php

/**
 * Index: default catch all template
 */

get_header(); ?>

<?php do_atomic('before_content'); ?>

<section id="content" role="main">


	<?php get_template_part('loop', 'index') ?>


</section>

<?php do_atomic('after_content'); ?>

<?php get_footer(); ?>