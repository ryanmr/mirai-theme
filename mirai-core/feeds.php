<?php
add_filter('posts_where', 'll_feed_delay');
function ll_feed_delay($where) {
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

function ll_remove_comments_rss( $for_comments ) {
    return;
}