<?php
if (!defined('ABSPATH')) exit;

class Bookhive_Shelves {

  public static function get_primary_shelf($user_id, $book_id) {
    global $wpdb;
    return $wpdb->get_var($wpdb->prepare(
      "SELECT shelf FROM {$wpdb->prefix}bookhive_shelves
       WHERE user_id=%d AND book_id=%d
       ORDER BY created_at DESC LIMIT 1",
      $user_id, $book_id
    ));
  }

  public static function set_primary_shelf($user_id, $book_id, $shelf) {
    global $wpdb;

    // remove existing primary shelves (Goodreads-style: one status shelf)
    $wpdb->delete("{$wpdb->prefix}bookhive_shelves", [
      'user_id' => intval($user_id),
      'book_id' => intval($book_id),
    ]);

    if ($shelf === 'none') return;

    $wpdb->insert("{$wpdb->prefix}bookhive_shelves", [
      'user_id' => intval($user_id),
      'book_id' => intval($book_id),
      'shelf'   => $shelf,
      'created_at' => current_time('mysql')
    ]);
  }
}
