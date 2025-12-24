<?php
if (!defined('ABSPATH')) exit;

class Bookhive_Reviews {

  public static function get_user_review($user_id, $book_id) {
    global $wpdb;
    return $wpdb->get_row($wpdb->prepare(
      "SELECT * FROM {$wpdb->prefix}bookhive_reviews WHERE user_id=%d AND book_id=%d",
      $user_id, $book_id
    ));
  }

  public static function get($book_id) {
    global $wpdb;
    return $wpdb->get_results($wpdb->prepare(
      "SELECT r.*, u.display_name
       FROM {$wpdb->prefix}bookhive_reviews r
       JOIN {$wpdb->users} u ON u.ID = r.user_id
       WHERE r.book_id=%d
       ORDER BY r.created_at DESC",
      $book_id
    ));
  }

  public static function averages($book_id) {
    global $wpdb;
    return $wpdb->get_row($wpdb->prepare(
      "SELECT ROUND(AVG(rating),1) rating,
              ROUND(AVG(spice),1) spice,
              COUNT(*) total
       FROM {$wpdb->prefix}bookhive_reviews
       WHERE book_id=%d",
      $book_id
    ));
  }

  public static function save($user_id, $book_id, $rating, $spice, $review) {
    global $wpdb;
    $wpdb->replace("{$wpdb->prefix}bookhive_reviews", [
      'user_id' => intval($user_id),
      'book_id' => intval($book_id),
      'rating'  => intval($rating),
      'spice'   => intval($spice),
      'review'  => $review,
      'created_at' => current_time('mysql')
    ]);
  }
}

