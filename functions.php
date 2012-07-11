<?php

require( trailingslashit(TEMPLATEPATH) . "hybrid-core/hybrid.php" );
new Hybrid();

add_action( 'after_setup_theme', 'mirai_setup_theme' );

function mirai_setup_theme() {

	$prefix = hybrid_get_prefix();

	debug_backtrace();

	add_theme_support( 'hybrid-core-menus', array( 'alpha') );
	add_theme_support( 'hybrid-core-sidebars', array( 'primary', 'subsidiary' ) );
	add_theme_support( 'hybrid-core-widgets' );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-theme-settings', array( 'about', 'footer' ) );
	add_theme_support( 'hybrid-core-drop-downs' );
	add_theme_support( 'hybrid-core-seo' );
	add_theme_support( 'hybrid-core-template-hierarchy' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'aside', 'link' ) );

	add_action( "{$prefix}_before_footer", 'mirai_get_primary_sidebar');

	add_action( "{$prefix}_header", 'hybrid_site_title' );
	add_action( "{$prefix}_header", 'hybrid_site_description' );

	add_action( "{$prefix}_before_entry", 'mirai_entry_title');
	add_action( "{$prefix}_before_entry", 'mirai_entry_symbol');
	add_action( "{$prefix}_before_entry", 'mirai_entry_date');

	add_action( "{$prefix}_after_entry", 'mirai_entry_meta');

}

function mirai_entry_title() {
	$tag = is_singular() ? 'h1' : 'h2';
	$class = sanitize_html_class( get_post_type() ) . '-title entry-title';

	$permalink = get_permalink();

	$title = the_title( '<header class="post-header"><'.$tag.' class="'.$class.'"><a href="'.$permalink.'">', '</a></'.$tag.'></header>', false );

	echo apply_atomic_shortcode('entry_title', $title);
}

function mirai_entry_date() {

	$date = false;
	$meta = '';

	if ( in_category('featured') ) $date = true;
	if ( is_singular() ) $date = true;

	if (true == $date) {
		$meta = '<aside class="entry-date">[entry-published]</aside>';
	}

	echo apply_atomic_shortcode('entry_date', $meta);

}

function mirai_entry_symbol() {
	if ( 'link' != get_post_format() ) return;

	$symbol = '<div class="linked-list-item"><a class="linked-list-symbol" href="'.get_permalink().'" rel="bookmark" title="'.the_title_attribute(array('before' => 'Permalink to: ', 'echo'=>0)).'">&#8766;</a></div>';

	echo apply_atomic_shortcode('entry_symbol', $symbol);

}

function mirai_entry_meta() {

	$meta = '<aside class="entry-meta"></aside>';

}

function mirai_get_primary_sidebar() {
	get_sidebar('primary');
}


?>