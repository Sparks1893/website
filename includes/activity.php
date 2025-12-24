<?php
if (!defined('ABSPATH')) exit;

class Bookhive_Activity {
  public static function log($user_id, $action, $book_id = null, $meta = null) {
    global $wpdb;
    $wpdb->insert("{$wpdb->prefix}bookhive_activity", [
      'user_id' => $user_id,
      'action' => $action,
      'book_id' => $book_id,
      'meta' => $meta ? wp_json_encode($meta) : null,
    ]);
  }
}

