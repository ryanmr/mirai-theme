<!DOCTYPE html>
<html>
<head>

<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />

<title><?php hybrid_document_title(); ?></title>

<link rel="stylesheet" href="<?php bloginfo( 'template_url' );?>/resources/css/normalize.css" type="text/css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" media="all" />

<?php wp_head(); ?>

</head>
<body class="<?php hybrid_body_class(); ?>">

<?php do_atomic('before_header'); ?>

<header id="site-header">
	
	<div id="header">
		<?php do_atomic('header'); ?>
	</div>

	<?php do_atomic('inside_header'); ?>

</header><!-- header -->

<?php do_atomic('after_header'); ?>

<?php do_atomic('before_container'); ?>

<div id="container">

