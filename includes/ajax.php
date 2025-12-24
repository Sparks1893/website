<?php
if (!defined('ABSPATH')) exit;

add_action('wp_ajax_bookhive_save_review', function () {
  if (!is_user_logged_in()) wp_send_json_error(['message' => 'Not logged in'], 401);

  check_ajax_referer('bookhive_nonce', 'nonce');

  $user_id = get_current_user_id();
  $book_id = intval($_POST['book_id'] ?? 0);

  $rating = max(1, min(5, intval($_POST['rating'] ?? 0)));
  $spice  = max(0, min(5, intval($_POST['spice'] ?? 0)));
  $review = sanitize_textarea_field($_POST['review'] ?? '');

  if (!$book_id) wp_send_json_error(['message' => 'Missing book_id'], 400);

  Bookhive_Reviews::save($user_id, $book_id, $rating, $spice, $review);
  Bookhive_Activity::log($user_id, 'rated_reviewed', $book_id, ['rating'=>$rating,'spice'=>$spice]);

  wp_send_json_success();
});

add_action('wp_ajax_bookhive_set_shelf', function () {
  if (!is_user_logged_in()) wp_send_json_error(['message' => 'Not logged in'], 401);

  check_ajax_referer('bookhive_nonce', 'nonce');

  $user_id = get_current_user_id();
  $book_id = intval($_POST['book_id'] ?? 0);
  $shelf   = sanitize_text_field($_POST['shelf'] ?? '');

  $allowed = ['want-to-read','currently-reading','read','none'];
  if (!$book_id || !in_array($shelf, $allowed, true)) {
    wp_send_json_error(['message' => 'Bad request'], 400);
  }

  Bookhive_Shelves::set_primary_shelf($user_id, $book_id, $shelf);
  Bookhive_Activity::log($user_id, 'shelf_set', $book_id, ['shelf'=>$shelf]);

  wp_send_json_success();
});

