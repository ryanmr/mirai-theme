<?php

/*
	Linked list and extended functionality.
*/

add_action('add_meta_boxes', 'll_add_meta_box');
add_action('save_post', 'll_save', 10, 2);
add_action('wp_before_admin_bar_render', 'll_admin_bar');
add_action('load-post-new.php', '_ll_format_action');

function _ll_format_action() {
		if ( isset($_GET['format']) && !empty($_GET['format']) ) {
			if ('link' == $_GET['format']) add_action('admin_footer', 'mirai_linked_list_preselect_script');
	}
}

add_action('admin_footer', 'mirai_linked_list_autoselect_script');


function _mirai_get_links_category() {
	$category = get_category_by_slug('links');
	$category_id = $category->term_id;
	return $category_id;
}



function mirai_linked_list_preselect_script() {
?>

<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#post-format-link').attr('checked', true);
		$('#in-category-<?php echo _mirai_get_links_category(); ?>').attr('checked', true);
	});
</script>

<?php
}

function mirai_linked_list_autoselect_script() {
?>

<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#ll_url').blur(function(){
			$('#post-format-link').attr('checked', true);
			$('#in-category-<?php echo _mirai_get_links_category(); ?>').attr('checked', true);
		});
	});
</script>

<?php
}

function ll_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->add_menu(array(
		'title' => 'Link',
		'href' => admin_url('post-new.php?format=link'),
		'parent' => 'new-content',
		'id' => 'mirai_linked_list'

	));
}

function ll_url_rewrite($content) {
	if ( 'link' == get_post_format() ) {
		$url = mirai_get_ll_url();
		if ( $url != false ) {
			echo '<![CDATA[' . $url . ']]>';
			return $url;
		}
	}
	echo $content;
	return $content;
}

function ll_permalink_insert($content) {
	$symbol = '&#8733;';
	if ( 'link' == get_post_format() && is_feed() ) {
		$content = $content . '<div><p style="font-size: 2em;"><a href="'.get_permalink().'">&#8733;</a></p></div>';
	} 
	return $content;
}

function ll_symbol_insert($content) {
	$symbol = '&#8733;';
	if ( 'link' == get_post_format() && is_feed() ) {
		//$content = '<![CDATA[&rarr;  ' . $content . ']]>';
		$content = '→  ' . $content . '';
	} 
	return $content;
}

add_filter('the_content', 'll_permalink_insert');
add_filter('the_excerpt_rss', 'll_permalink_insert');
add_action('the_permalink_rss', 'll_url_rewrite');
add_filter('the_title_rss', 'll_symbol_insert');



add_filter('post_comments_feed_link', 'll_remove_comments_rss');


function ll_add_meta_box() {
	add_meta_box('mirai_linked_list', 'Linked List URL', 'll_box', 'post');
}

function ll_box($object, $box) {

	wp_nonce_field( basename(__FILE__), 'll_nonce' );

	echo '<p>';
	echo '<label for="ll_url">';
	_e('Add a URL to replace the title-permalink for this post in the <abbr>Linked List</abbr>.');
	echo '</label>';
	echo '<input type="text" id="ll_url" name="ll_url" value="' . esc_attr( get_post_meta($object->ID, 'll_url', true) ) . '" size="30" class="widefat" autocomplete="off" />';
	echo '</p>';

}



function ll_save($post_id, $post) {

	if ( !isset($_POST['ll_nonce']) || !wp_verify_nonce($_POST['ll_nonce'], basename(__FILE__)) ) {
		return $post_id;
	}

	$post_type = get_post_type_object($post->post_type);
	if ( !current_user_can($post_type->cap->edit_post, $post_id) ) {
		return $post_id;
	}

	$new = (isset($_POST['ll_url'])) ? sanitize_text_field($_POST['ll_url']) : '';

	$meta_key = 'll_url';

	$meta_value = get_post_meta($post_id, $meta_key, true);

	if ( $new && '' == $meta_value ) {
		add_post_meta($post_id, $meta_key, $new, true);
	} elseif ($new && $new != $meta_value) {
		update_post_meta($post_id, $meta_key, $new);
	} elseif ('' == $new && $meta_value) {
		delete_post_meta($post_id, $meta_key, $meta_value);
	}

}

function mirai_get_ll_url() {

	$id = get_the_ID();
	if ( empty($id) ) return false;

	$ll_url = get_post_meta($id, 'll_url', true);
	
	$ll_url = apply_filters('pre_ll_url', $ll_url);

	if ( empty($ll_url) ) return false;

	return $ll_url;
}

?>