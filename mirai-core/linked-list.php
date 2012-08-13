<?php

/*
	Linked list and extended functionality.
*/

class Mirai_LinkedList {

	public static function initialize() {
		self::attach_actions();
		self::attach_filters();
	}

	public static function attach_actions() {
		add_action('add_meta_boxes', 'Mirai_LinkedList::add_meta_box');
		add_action('save_post', 'Mirai_LinkedList::save_box', 10, 2);
		add_action('wp_before_admin_bar_render', 'Mirai_LinkedList::modify_admin_bar');
		add_action('load-post-new.php', 'Mirai_LinkedList::new_link');
		add_action('admin_footer', 'Mirai_LinkedList::script_autoselect');
	}

	public static function attach_filters() {
		add_filter('the_content', 'Mirai_LinkedList::feed_permalink');
		add_filter('the_excerpt_rss', 'Mirai_LinkedList::feed_permalink');
		add_action('the_permalink_rss', 'Mirai_LinkedList::feed_title_url');
		add_filter('the_title_rss', 'Mirai_LinkedList::feed_symbol');
	}

	public static function add_meta_box() {
		add_meta_box('mirai_linked_list', 'Linked List URL', 'Mirai_LinkedList::display_box', 'post');
	}

	public static function new_link() {
		if ( Mirai_LinkedList::admin_is_link_format() ) add_action('admin_footer', 'Mirai_LinkedList::script_preselect');
	}

	public static function admin_is_link_format() {
		return (isset($_GET['format']) && !empty($_GET['format']) && ('link' == $_GET['format']));
	}

	public static function display_box($object, $box) {
		wp_nonce_field( basename(__FILE__), 'll_nonce' );

		echo '<p>';
		echo '<label for="ll_url">';
		_e('Add a URL to replace the title-permalink for this post in the <abbr>Linked List</abbr>.');
		echo '</label>';
		echo '<input type="text" id="ll_url" name="ll_url" value="' . esc_attr( get_post_meta($object->ID, 'll_url', true) ) . '" size="30" class="widefat" autocomplete="off" />';
		echo '</p>';
	}

	public static function save_box($post_id, $post) {
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

	public static function get_linked_list_url() {
		$id = get_the_ID();
		if ( empty($id) ) return false;

		$ll_url = get_post_meta($id, 'll_url', true);
		
		$ll_url = apply_filters('pre_ll_url', $ll_url);

		if ( empty($ll_url) ) return false;

		return $ll_url;
	}

	public static function modify_admin_bar() {
		global $wp_admin_bar;
		$wp_admin_bar->add_menu(array(
			'title' => 'Link',
			'href' => admin_url('post-new.php?format=link'),
			'parent' => 'new-content',
			'id' => 'Mirai_LinkedList_linked_list'

		));
	}

	public static function feed_title_url($content) {
		if ( 'link' == get_post_format() ) {
			$url = Mirai_LinkedList::get_linked_list_url();
			if ( $url != false ) {
				//echo '<![CDATA[' . $url . ']]>';
				return $url;
			}
		}
		//echo $content;
		return $content;
	}

	public static function feed_permalink($content) {
		$symbol = '&#8733;';
		if ( 'link' == get_post_format() && is_feed() ) {
			$content = $content . '<div><p style="font-size: 2em;"><a href="'.get_permalink().'">&#8733;</a></p></div>';
		} 
		return $content;
	}

	public static function feed_symbol($content) {
		$symbol = '&#8733;';
		if ( 'link' == get_post_format() && is_feed() ) {
			$content = '→  ' . $content . '';
		} 
		return $content;
	}

	public static function script_autoselect() {
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('#ll_url').blur(function(){
					$('#post-format-link').attr('checked', true);
					$('#in-category-<?php echo Mirai_LinkedList::get_links_category(); ?>').attr('checked', true);
				});
			});
		</script>
		<?php
	}

	public static function script_preselect() {
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
					$('#post-format-link').attr('checked', true);
					$('#in-category-<?php echo Mirai_LinkedList::get_links_category(); ?>').attr('checked', true);
			});
		</script>
		<?php
	}

	public static function get_links_category() {
		$category = get_category_by_slug('links');
		$category_id = $category->term_id;
		return $category_id;
	}

}


?>