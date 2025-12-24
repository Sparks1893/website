<?php
if (!defined('ABSPATH')) exit;

class Bookhive_DB {
  public static function install() {
    global $wpdb;
    $c = $wpdb->get_charset_collate();
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    dbDelta("CREATE TABLE {$wpdb->prefix}bookhive_reviews (
      id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      user_id BIGINT UNSIGNED NOT NULL,
      book_id BIGINT UNSIGNED NOT NULL,
      rating TINYINT NOT NULL,
      spice TINYINT DEFAULT 0,
      review TEXT,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      UNIQUE KEY uniq_review (user_id, book_id)
    ) $c;");

    dbDelta("CREATE TABLE {$wpdb->prefix}bookhive_shelves (
      id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      user_id BIGINT UNSIGNED NOT NULL,
      book_id BIGINT UNSIGNED NOT NULL,
      shelf VARCHAR(50) NOT NULL,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      UNIQUE KEY uniq_shelf (user_id, book_id, shelf)
    ) $c;");

    dbDelta("CREATE TABLE {$wpdb->prefix}bookhive_activity (
      id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      user_id BIGINT UNSIGNED NOT NULL,
      action VARCHAR(50) NOT NULL,
      book_id BIGINT UNSIGNED,
      meta LONGTEXT,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $c;");

    dbDelta("CREATE TABLE {$wpdb->prefix}bookhive_series (
      id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255),
      slug VARCHAR(255),
      UNIQUE KEY uniq_slug (slug)
    ) $c;");
  }
}

