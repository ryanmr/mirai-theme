<?php

class Mirai_Feeds {

	public static function initialize() {
		add_action('posts_where', 'Mirai_Feeds::feed_delay');
		add_filter('post_comments_feed_link', 'Mirai_Feeds::remove_comments');
	}

	public static function feed_delay($where) {
	  global $wpdb;
	  
	  $do_delay = true;
	  if (isset($_GET['nodelay'])) $do_delay = false; 

	  if (is_feed() && $do_delay) {
	    $now = gmdate('Y-m-d H:i:s');
	    $wait = '15';
	    $device = 'MINUTE';
	    $where .= " AND TIMESTAMPDIFF($device, $wpdb->posts.post_date_gmt, '$now') > $wait ";
	  }
	  
	  return $where;
	}

	public static function remove_comments($for_comments) {
		return;
	}

}
