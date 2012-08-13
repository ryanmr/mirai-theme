<?php

require( trailingslashit(TEMPLATEPATH) . "hybrid-core/hybrid.php" );
new Hybrid();

require( trailingslashit(TEMPLATEPATH) . "mirai-core/linked-list.php" );
require( trailingslashit(TEMPLATEPATH) . "mirai-core/feeds.php" );

add_action( 'after_setup_theme', 'mirai_setup_theme' );

function mirai_setup_theme() {

	Mirai_LinkedList::initialize();
	Mirai_Feeds::initialize();

	$prefix = hybrid_get_prefix();

	add_theme_support( 'hybrid-core-menus', array( 'primary') );
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
	add_theme_support( 'loop-pagination ');

	hybrid_set_content_width( 600 );

	add_action( "{$prefix}_inside_header", 'mirai_get_primary_menu');

	add_action( "{$prefix}_after_content", 'mirai_get_navigation');
	add_action( "{$prefix}_after_single", 'mirai_get_navigation');

	add_action( "{$prefix}_header", 'hybrid_site_title' );
	add_action( "{$prefix}_header", 'hybrid_site_description' );

	add_action( "{$prefix}_before_entry", 'mirai_entry_title');
	add_action( "{$prefix}_before_entry", 'mirai_entry_date');

	add_action( "{$prefix}_after_entry", 'mirai_entry_meta');

	add_action( "{$prefix}_before_comment", 'mirai_comment_header');
	add_action( "{$prefix}_after_comment", 'mirai_comment_meta');

	add_action( "{$prefix}_footer", 'mirai_footer' );

	add_general_actions();

}

function add_general_actions() {
	add_action('comment_form', 'mirai_commentform' );
	add_action('wp_before_admin_bar_render', 'mirai_admin_bar');
	add_action('wp_head', 'mirai_viewport');
	add_action('init', 'mirai_header');

	if ( is_admin() ) {
		add_action('admin_menu', 'mirai_admin_menu');
	}
}

function mirai_viewport() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0" />';
}

function mirai_header() {
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'rsd_link');
}

function mirai_admin_menu() {
	remove_menu_page('link-manager.php');
}

function mirai_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('new-link', 'new-content');
	$wp_admin_bar->remove_menu('new-media', 'new-content');
	$wp_admin_bar->remove_menu('new-page', 'new-content');
	$wp_admin_bar->remove_menu('new-user', 'new-content');
}

function mirai_get_primary_menu() {
	get_template_part( 'menu', 'primary' );
}


function mirai_entry_title() {
	$tag = is_singular() ? 'h1' : 'h2';
	$class = sanitize_html_class( get_post_type() ) . '-title entry-title';

	$permalink = mirai_get_entry_title_permalink();
	$symbol = mirai_get_entry_symbol();

	$title = the_title( '<header class="post-header"><'.$tag.' class="'.$class.'"><a href="'.$permalink.'">', '</a>'.$symbol.'</'.$tag.'></header>', false );

	echo apply_atomic_shortcode('entry_title', $title);
}

function mirai_get_entry_title_permalink() {
	$permalink = get_permalink();

	if ( class_exists('Mirai_LinkedList') && 'link' == get_post_format() ) {
		$url = Mirai_LinkedList::get_linked_list_url();

		if ( false != $url ) {
			$permalink = $url;
		}
	}

	return $permalink;

}

function mirai_entry_date() {

	$date = false;
	$meta = '';

	if ( in_category('featured') ) $date = true;
	if ( is_singular() ) $date = true;
	if ( is_page() ) $date = false;

	if (true == $date) {
		$meta = '<aside class="entry-date">[entry-published]</aside>';
	}

	echo apply_atomic_shortcode('entry_date', $meta);

}

function mirai_get_entry_symbol() {
	if ( 'link' != get_post_format() ) return "";

	$symbol = '<span class="linked-list-item"><a class="linked-list-symbol" href="'.get_permalink().'" rel="bookmark" title="'.the_title_attribute(array('before' => 'Permalink to: ', 'echo'=>0)).'">&#8733;</a></span>';

	return $symbol;
}

function mirai_entry_symbol() {

	$symbol = mirai_get_entry_symbol();

	echo apply_atomic_shortcode('entry_symbol', $symbol);

}

function mirai_entry_meta() {

	$edit_part = '[entry-edit-link]';
	$tag_part = '[entry-terms taxonomy="post_tag" before="Tagged: "]';

	if ( !is_single() ) $tag_part = '';

	$contents = $tag_part . ' ' . $edit_part;

	$meta = '<aside class="entry-meta">'.$contents.'</aside>';

	echo apply_atomic_shortcode('entry_meta', $meta);

}

function mirai_get_primary_sidebar() {
	get_sidebar('primary');
}

function mirai_get_navigation() {
	remove_action(hybrid_get_prefix()."_after_content", 'mirai_get_navigation');
	/*
		Kind of a hack. This will prevent the later navigation insert
		from running later and making a duplicate.
		This puts a single navigation series insert above the comments
		on single pages.
	*/
	locate_template( array('loop-nav.php') , true );
}

function mirai_comment_header() {
	echo apply_atomic_shortcode('comment_header', '<div class="comment-header comment-header-data">[comment-author]: </div>');
}

function mirai_comment_meta() {
	echo apply_atomic_shortcode('comment_meta', '<div class="comment-meta"> [comment-published] [comment-edit-link before=" | "] [comment-permalink before="| "] [comment-reply-link before="| "] </div>');
}

function mirai_footer() {

	$footer_insert = hybrid_get_setting( 'footer_insert' );

	if ( !empty( $footer_insert ) )
		echo '<div class="footer-insert">' . do_shortcode( $footer_insert ) . '</div>';

}

function mirai_commentform() {
	function _mirai_commentform_hide() {
		include(get_template_directory() . '/mirai-core/embed/comment-hide.js.php');
	}
	$number = get_comments_number();
	if ( 0 == $number ) add_action('wp_footer', '_mirai_commentform_hide');
}

?>